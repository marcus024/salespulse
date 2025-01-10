<?php
header('Content-Type: application/json');

// Include database connection
include("../../../auth/db.php");

try {
    $query = "SELECT * FROM todo_tb";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "tasks" => $tasks]);
} catch (Exception $e) {
    error_log("Error fetching tasks: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "Failed to fetch tasks."]);
}
?>
