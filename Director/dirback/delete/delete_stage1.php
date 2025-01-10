<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database configuration (db.php already connects to the database)
    include("../../../auth/db.php"); 

    // Get the project ID from POST data
    $projectId = isset($_POST['project_id']) ? $_POST['project_id'] : null;

    if (!$projectId) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required field: project_id.'
        ]);
        exit;
    }

    try {
        // Use the existing connection from db.php
        // Begin a transaction (to ensure data consistency)
        $conn->beginTransaction();

        // Update the status of the project in the 'projecttb' table to "Cancelled"
        $updateProjectStatusQuery = "UPDATE projecttb SET status = 'Cancelled' WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateProjectStatusQuery);
        $stmt->execute([$projectId]);

        // Update the status of the stage in the 'stageone' table to "Cancelled"
        $updateStageStatusQuery = "UPDATE stageone SET status_stage_one = 'Cancelled' WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageStatusQuery);
        $stmt->execute([$projectId]);

        // Commit the transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Project and stage statuses updated to "Cancelled" successfully.'
        ]);
    } catch (PDOException $e) {
        // Rollback transaction if there's an error
        $conn->rollBack();

        echo json_encode([
            'success' => false,
            'message' => 'Error updating data: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>
