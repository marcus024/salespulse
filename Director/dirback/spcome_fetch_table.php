<?php
// db_connection.php - include your database connection here
include '../../auth/db.php';

session_start();
$user_id = $_SESSION['user_id_c'];  // Assuming you're storing the user ID in session

// SQL Query to fetch data
$sql = "
    SELECT 
        p.company_name, 
        p.start_date, 
        p.end_date,
        s.endC, 
        s.startC
    FROM projecttb p
    JOIN stagefive s ON p.project_unique_id = s.project_unique_id
    WHERE p.user_id_cur = ?
";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

// Return data as JSON
echo json_encode($projects);
?>
