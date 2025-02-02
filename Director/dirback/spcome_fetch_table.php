<?php
// db_connection.php - include your database connection here
include '../../auth/db.php';

session_start();
$user_id = $_SESSION['user_id_c'];  // Assuming you're storing the user ID in session

$response = [];  // Array to store the response

// Check if user_id is set
if (!$user_id) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'User ID not found in session.']);
    exit();
}

// SQL Query to fetch data
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

// Prepare and execute the query
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);  // Internal Server Error
    echo json_encode(['error' => 'Failed to prepare SQL statement.']);
    exit();
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    http_response_code(500);  // Internal Server Error
    echo json_encode(['error' => 'Failed to execute SQL query.']);
    exit();
}

$result = $stmt->get_result();

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

// Check if projects are found
if (empty($projects)) {
    http_response_code(404);  // Not Found
    echo json_encode(['error' => 'No projects found for the user.']);
    exit();
}

// Return data as JSON
echo json_encode($projects);
?>
