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
        s.endC AS net_sales, 
        s.startC AS gross_profit
    FROM projecttb p
    JOIN stagefive s ON p.project_unique_id = s.project_unique_id
    WHERE p.user_id_cur = ?
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to prepare SQL statement: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to execute SQL query: ' . $stmt->error]);
    exit();
}

$result = $stmt->get_result();

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

if (empty($projects)) {
    http_response_code(404);
    echo json_encode(['error' => 'No projects found for the user.']);
    exit();
}

echo json_encode($projects);
?>
