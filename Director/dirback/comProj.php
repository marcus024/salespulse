<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php'); // Adjust path to match your DB connection file

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => true, 'message' => 'Invalid request method']);
    exit;
}

$projectId = $_POST['project_id'] ?? '';
if (empty($projectId)) {
    echo json_encode(['error' => true, 'message' => 'Missing project_id']);
    exit;
}

try {
    // Update the project status to "Completed" and the end_date to today's date
    $sql = "
        UPDATE projecttb
        SET 
            status = 'Completed',
            end_date = CURDATE(),
            duration = DATEDIFF(CURDATE(), start_date)
        WHERE project_unique_id = :pid
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pid', $projectId, PDO::PARAM_STR);
    $stmt->execute();

    // Check if any row was actually updated
    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => false, 'message' => 'Project completed successfully']);
    } else {
        // Either the project was not found or it was already in Completed status
        echo json_encode(['error' => true, 'message' => 'Project not found or already completed']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => 'DB Error: ' . $e->getMessage()]);
}
