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
        p.status,
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

    echo json_encode($projects);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit();
}
?>
