<?php
// Include the database connection
require_once '../auth/db.php'; // Replace with the actual path to your database connection script

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

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Project successfully canceled.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to cancel the project.']);
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
