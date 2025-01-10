<?php
header('Content-Type: application/json');
include '../../auth/db.php';

session_start();

$currentCompany = $_SESSION['company'] ?? 1;  

// Grab filters from POST
$selectedUser    = $_POST['selectedUser'] ?? 'All';
$selectedProject = $_POST['selectedProject'] ?? 'All';
$selectedMonth   = $_POST['selectedMonth'] ?? 'All';

/****************************************
 * 1) Fetch list of Users from salesauth
 ****************************************/
try {
    $sqlUsers = "
        SELECT user_id_current, lastname, firstname
        FROM salesauth
        WHERE company = :currentCompany
    ";
    $stmtUsers = $conn->prepare($sqlUsers);
    $stmtUsers->bindParam(':currentCompany', $currentCompany, PDO::PARAM_STR);
    $stmtUsers->execute();
    $usersListRaw = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Combine lastname and firstname
    $userNamesList = array_map(function($row) {
        return trim($row['lastname'] . ', ' . $row['firstname']);
    }, $usersListRaw);

} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching users: ' . $e->getMessage()]);
    exit;
}

/********************************************************
 * 2) Determine selected user's ID for both Projects
 *    and Peak Data filtering
 ********************************************************/
$userIdValForPeak = null; // We'll use this later for the peak_tb query
try {
    if ($selectedUser === 'All') {
        // No specific user is selected => no user filter
        $sqlProjects = "
            SELECT p.*
            FROM projecttb p
            JOIN salesauth s ON p.user_id_cur = s.user_id_current
            WHERE s.company = :currentCompany
        ";
        $stmtProjects = $conn->prepare($sqlProjects);
        $stmtProjects->bindParam(':currentCompany', $currentCompany, PDO::PARAM_STR);
    } else {
        // Split "Lastname, Firstname"
        list($lname, $fname) = array_map('trim', explode(',', $selectedUser));

        // 2.1) Find that user’s ID
        $sqlUserId = "
            SELECT user_id_current
            FROM salesauth
            WHERE company   = :company
              AND lastname  = :lname
              AND firstname = :fname
            LIMIT 1
        ";
        $stmtGetUserId = $conn->prepare($sqlUserId);
        $stmtGetUserId->bindParam(':company', $currentCompany, PDO::PARAM_STR);
        $stmtGetUserId->bindParam(':lname',   $lname);
        $stmtGetUserId->bindParam(':fname',   $fname);
        $stmtGetUserId->execute();

        $userInfo  = $stmtGetUserId->fetch(PDO::FETCH_ASSOC);
        // If not found, userIdVal is 0 (meaning no results match)
        $userIdVal = $userInfo ? $userInfo['user_id_current'] : 0;

        // We'll use the same ID to filter the chart
        $userIdValForPeak = $userIdVal;

        // 2.2) Fetch projects for that user
        $sqlProjects = "
            SELECT p.*
            FROM projecttb p
            JOIN salesauth s ON p.user_id_cur = s.user_id_current
            WHERE s.company = :company
              AND p.user_id_cur = :userIdVal
        ";
        $stmtProjects = $conn->prepare($sqlProjects);
        $stmtProjects->bindParam(':company',   $currentCompany, PDO::PARAM_STR);
        $stmtProjects->bindParam(':userIdVal', $userIdVal,      PDO::PARAM_INT);
    }

    // Execute the query
    $stmtProjects->execute();
    $projectsData = $stmtProjects->fetchAll(PDO::FETCH_ASSOC);

    // For the dropdown, use the `client_name` or some other column
    $projectsList = array_map(function($row) {
        // Fallback if project_unique_id is empty
        return !empty($row['company_name']) 
               ? $row['company_name'] 
               : ('Project #' . $row['id']);
    }, $projectsData);

} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching projects: ' . $e->getMessage()]);
    exit;
}

/***************************************
 * 3) Calculate summary data for cards
 ***************************************/
$totalUsers    = count($userNamesList);
$totalProjects = count($projectsData);

// Compute average duration from valid start_date/end_date
$durations = [];
foreach ($projectsData as $proj) {
    if (!empty($proj['start_date']) && !empty($proj['end_date'])) {
        try {
            $start = new DateTime($proj['start_date']);
            $end   = new DateTime($proj['end_date']);
            $diff  = $end->diff($start)->days;
            $durations[] = $diff;
        } catch (Exception $e) {
            continue;
        }
    }
}

$avgDuration = (count($durations) > 0) 
    ? array_sum($durations) / count($durations) 
    : 0;
$avgDuration = round($avgDuration, 2);

/********************************************************
 * 4) Fetch Data for the Chart (Peak Users per Day)
 *    - Filter by $selectedMonth if not 'All'
 *    - Filter by user ID if a specific user is selected
 ********************************************************/
try {
    // We'll build a base query
    $sqlPeakBase = "
        SELECT 
            DATE(logged_in) AS log_date,
            COUNT(DISTINCT peak_user) AS total_peak
        FROM peak_tb
    ";

    // Build conditions array for dynamic WHERE
    $conditions = [];

    // If a user is selected (and not 0), then filter by that user_id
    if (!empty($userIdValForPeak)) {
        $conditions[] = "peak_user = :peakUserVal";
    }

    // If a month is selected (not 'All'), filter by month(logged_in)
    if ($selectedMonth !== 'All') {
        $conditions[] = "MONTH(logged_in) = :monthNum";
    }

    // Combine conditions into a WHERE clause if any
    if (!empty($conditions)) {
        $sqlPeakBase .= " WHERE " . implode(" AND ", $conditions);
    }

    // Group and sort
    $sqlPeakBase .= " 
        GROUP BY DATE(logged_in)
        ORDER BY DATE(logged_in) ASC
    ";

    // Prepare
    $stmtPeak = $conn->prepare($sqlPeakBase);

    // Bind user param if we have one
    if (!empty($userIdValForPeak)) {
        $stmtPeak->bindParam(':peakUserVal', $userIdValForPeak, PDO::PARAM_INT);
    }

    // Bind month param if needed
    if ($selectedMonth !== 'All') {
        $monthMap = [
            'January' => '01','February' => '02','March' => '03','April' => '04',
            'May' => '05','June' => '06','July' => '07','August' => '08',
            'September' => '09','October' => '10','November' => '11','December' => '12'
        ];
        $monthNum = $monthMap[$selectedMonth] ?? '01';
        $stmtPeak->bindParam(':monthNum', $monthNum, PDO::PARAM_INT);
    }

    // Execute
    $stmtPeak->execute();
    $peakRows = $stmtPeak->fetchAll(PDO::FETCH_ASSOC);

    // Format chart data
    $labels     = [];
    $dataPoints = [];
    foreach ($peakRows as $row) {
        $labels[]     = $row['log_date'];
        $dataPoints[] = (int)$row['total_peak'];
    }

    $chartData = [
        'labels' => $labels,
        'data'   => $dataPoints
    ];

} catch (Exception $e) {
    echo json_encode(['error' => 'Error fetching chart data: ' . $e->getMessage()]);
    exit;
}

$response = [
    'totalUsers'    => $totalUsers,
    'totalProjects' => $totalProjects,
    'avgDuration'   => $avgDuration,
    'usersList'     => $userNamesList,
    'projectsList'  => $projectsList,
    'chartData'     => $chartData
];

echo json_encode($response);
exit;
