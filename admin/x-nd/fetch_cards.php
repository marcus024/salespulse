<?php


// Retrieve user ID and company from the session
$user_id = $_SESSION['user_id_c'] ?? null;
$user_company = $_SESSION['company'] ?? null;

if (!$user_id) {
    echo "<script>
            alert('User not logged in. Please log in.');
            window.location.href = '../../login.php';
          </script>";
    exit;
}

// Initialize variables
$totalUsers    = 0;
$totalProjects = 0;
$avgDuration   = 0.0;

try {
    

    // Ensure that the user's company is set
    if (!$user_company) {
        throw new Exception('User company not set in session.');
    }

    // SQL query to fetch total users, total projects, and average duration based on company
    $aggregateSql = "
        SELECT 
            COUNT(*) AS total_users,
            COUNT(p.project_unique_id) AS total_projects,
            AVG(DATEDIFF(p.end_date, p.start_date)) AS avg_duration
        FROM salesauth s
        LEFT JOIN projecttb p ON p.user_id_cur = s.user_id_current AND p.end_date IS NOT NULL
        WHERE s.company = :company
    ";

    $aggregateStmt = $conn->prepare($aggregateSql);
    $aggregateStmt->bindParam(':company', $user_company, PDO::PARAM_STR);
    $aggregateStmt->execute();
    $aggregateResult = $aggregateStmt->fetch();

    if ($aggregateResult) {
        $totalUsers    = $aggregateResult['total_users'] ?? 0;
        $totalProjects = $aggregateResult['total_projects'] ?? 0;
        $avgDuration   = isset($aggregateResult['avg_duration']) ? round($aggregateResult['avg_duration'], 2) : 0.0;
    }


    $usersSql = "
        SELECT s.user_id_current, CONCAT(s.firstname, ' ', s.lastname) AS full_name
        FROM salesauth s
        WHERE s.company = :company
        ORDER BY s.firstname, s.lastname
    ";

    $usersStmt = $conn->prepare($usersSql);
    $usersStmt->bindParam(':company', $user_company, PDO::PARAM_STR);
    $usersStmt->execute();
    $usersResult = $usersStmt->fetchAll();

    if ($usersResult) {
        foreach ($usersResult as $user) {
            $usersList[] = [
                'user_id'   => $user['user_id_current'],
                'full_name' => $user['full_name'],
            ];
        }
    }

    // -------------------------------
    // 3. Fetch Projects Owned by Users
    // -------------------------------
    // Extract user_ids from the usersList
    $userIds = array_column($usersList, 'user_id');

    if (!empty($userIds)) {
        // Prepare placeholders for IN clause
        $placeholders = rtrim(str_repeat('?, ', count($userIds)), ', ');

        $projectsSql = "
            SELECT DISTINCT p.company_name
            FROM projecttb p
            WHERE p.user_id_cur IN ($placeholders)
                AND p.end_date IS NOT NULL
            ORDER BY p.company_name
        ";

        $projectsStmt = $conn->prepare($projectsSql);
        foreach ($userIds as $index => $userId) {
            // PDO placeholders are 1-indexed
            $projectsStmt->bindValue($index + 1, $userId, PDO::PARAM_INT);
        }
        $projectsStmt->execute();
        $projectsResult = $projectsStmt->fetchAll();

        if ($projectsResult) {
            foreach ($projectsResult as $project) {
                $projectsList[] = $project['company_name'];
            }
        }
    }

} catch (PDOException $e) {
    // Handle PDO (database) exceptions
    echo "<script>
            alert('Database Error: " . htmlspecialchars($e->getMessage()) . "');
            window.history.back();
          </script>";
    exit;
} catch (Exception $e) {
    // Handle general exceptions
    echo "<script>
            alert('Error: " . htmlspecialchars($e->getMessage()) . "');
            window.history.back();
          </script>";
    exit;
}
?>
