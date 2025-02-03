<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// db_connection.php - include your database connection here
include '../../auth/db.php';

session_start();
$user_id = $_SESSION['user_id_c'];

$response = [];  // Array to store the response

if (!$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID not found in session.']);
    exit();
}

$sql = "
    SELECT 
        p.company_name AS project_name, 
        p.start_date, 
        p.end_date,
        p.status AS projectStatus,
        s.endC AS net_sales, 
        s.startC AS gross_profit
    FROM projecttb p
    JOIN stagefive s ON p.project_unique_id = s.project_unique_id
    WHERE p.user_id_cur = :user_id AND p.status = 'Completed'
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR); // Use PDO binding

    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($projects)) {
        http_response_code(404);
        echo json_encode(['error' => 'No projects found for the user.']);
        exit();
    }

    // Iterate through each project and calculate the commission
    foreach ($projects as &$project) {
        $grossProfit = (float) $project['gross_profit'];
        $netSales = (float) $project['net_sales'];

        if ($netSales > 0) {
            $totalComRate = $grossProfit / $netSales;
        } else {
            $totalComRate = 0;
        }

        // Convert to percentage and round down to nearest whole number
        $wholeNumberComRate = floor($totalComRate * 100);

        // Determine individual commission rate
        if ($wholeNumberComRate < 15) {
            $individualComRate = 0.02;
        }elseif ($wholeNumberComRate === 15) {
            $individualComRate = 0.025;
        }elseif ($wholeNumberComRate === 16) {
            $individualComRate = 0.0275;
        } elseif ($wholeNumberComRate === 17) {
            $individualComRate = 0.03;
        } elseif ($wholeNumberComRate === 18) {
            $individualComRate = 0.0325;
        } elseif ($wholeNumberComRate === 19) {
            $individualComRate = 0.035;
        } elseif ($wholeNumberComRate === 20) {
            $individualComRate = 0.0375;
        } elseif ($wholeNumberComRate === 21) {
            $individualComRate = 0.04;
        } elseif ($wholeNumberComRate === 22) {
            $individualComRate = 0.0425;
        } elseif ($wholeNumberComRate === 23) {
            $individualComRate = 0.045;
        } elseif ($wholeNumberComRate === 24) {
            $individualComRate = 0.0475;
        } elseif ($wholeNumberComRate >= 25) {
            $individualComRate = 0.05;
        } else {
            $individualComRate = 0; // No commission if rate is less than 13%
        }

        // Compute Commission Value
        $commissionValue = $grossProfit * $individualComRate;

        // Compute Actual Commission (70% of commission value)
        $actualCommission = $commissionValue * 0.70;

        // Add commission to project data
        $project['commission'] = round($actualCommission, 2);
    }

    // Return projects with commission data
    echo json_encode($projects);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}
?>
