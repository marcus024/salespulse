<?php
header('Content-Type: application/json');

// Include database connection and start session
include("../../../auth/db.php");
session_start();

try {
    // Retrieve POST data
    $taskName = trim($_POST['taskname'] ?? '');
    $assignedTo = trim($_POST['assigned'] ?? '');
    $startDate = $_POST['starttask'] ?? '';
    $endDate = $_POST['endtask'] ?? '';

    // Retrieve the current user ID from the session
    $currentUserId = $_SESSION['user_id_c'] ?? null;

    // Debugging: Log received data
    error_log("Received POST data: " . json_encode($_POST));
    error_log("User ID from session: " . $currentUserId);

    // Validate input
    if (empty($taskName) || empty($assignedTo) || empty($startDate) || empty($endDate) || empty($currentUserId)) {
        echo json_encode(["success" => false, "message" => "All fields are required, including the user ID."]);
        error_log("Validation failed: Missing fields.");
        exit;
    }

    // Validate date formats
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
        echo json_encode(["success" => false, "message" => "Invalid date format. Use YYYY-MM-DD."]);
        error_log("Validation failed: Invalid date format.");
        exit;
    }

    // Insert task into the database
    $query = "INSERT INTO todo_tb (taskname, assigned, starttask, endtask, user_id_current) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Failed to prepare statement: " . $conn->errorInfo()[2]);
        echo json_encode(["success" => false, "message" => "Database error: Failed to prepare statement."]);
        exit;
    }

    $stmt->execute([$taskName, $assignedTo, $startDate, $endDate, $currentUserId]);

    // Debugging: Check for errors after execution
    if ($stmt->errorCode() !== '00000') {
        error_log("Execution failed: " . $stmt->errorInfo()[2]);
        echo json_encode(["success" => false, "message" => "Failed to insert task into the database."]);
        exit;
    }

    // Return success response
    echo json_encode(["success" => true, "message" => "Task added successfully."]);
} catch (Exception $e) {
    // Log error and return failure response
    error_log("Error adding task: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An error occurred while adding the task."]);
}
?>
