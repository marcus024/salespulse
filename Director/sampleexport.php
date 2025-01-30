<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins (you can restrict this)
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include('../auth/db.php'); // Ensure this contains a valid `$conn` connection

// Check if database connection is established
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(["error" => "Database connection failed", "details" => $conn->connect_error]);
    exit;
}

// Fetch all project data from projecttb
$sql = "SELECT * FROM projecttb";
$result = $conn->query($sql);

$projects = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    $result->free();
} else {
    echo json_encode(["error" => "Query failed", "details" => $conn->error]);
    exit;
}

// Return JSON data
echo json_encode($projects, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conn->close();
?>
