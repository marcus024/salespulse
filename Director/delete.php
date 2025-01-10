<?php
// Include the database connection
require_once '../auth/db.php';

header('Content-Type: application/json');

try {
    // Decode the incoming JSON payload
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the required data is provided
    if (!isset($data['project_unique_id'])) {
        echo json_encode(['success' => false, 'message' => 'Project ID is missing.']);
        exit;
    }

    $projectId = $data['project_unique_id'];

    // Debugging logs
    error_log("Incoming Data: " . print_r($data, true));
    error_log("Project ID: " . $projectId);

    // Get today's date in YYYY-MM-DD format
    $today = date('Y-m-d');

    // Prepare the SQL query to update the project's status and set end_date to today's date
    $stmt = $conn->prepare("
    UPDATE projecttb 
    SET status = 'Cancelled', 
        end_date = :end_date
    WHERE project_unique_id = :unique_id
    ");

    // Bind parameters
    $stmt->bindParam(':end_date', $today);
    $stmt->bindParam(':unique_id', $projectId, PDO::PARAM_STR);

    // Execute the query and check if rows are updated
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Project successfully canceled.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No project was updated. It may not exist or is already canceled.']);
    }
} catch (PDOException $e) {
    // Handle database errors
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
