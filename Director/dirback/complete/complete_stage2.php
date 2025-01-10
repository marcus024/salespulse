<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database configuration (db.php should contain the $conn object)
    include("../../../auth/db.php");

    // Collect form data from the POST request
    $projectUniqueId = isset($_POST['project_id']) ? $_POST['project_id'] : null;
    $currentStep = isset($_POST['current_step']) ? $_POST['current_step'] : null;

    // Validate required fields
    if (!$projectUniqueId || !$currentStep) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: project_id or current_step.'
        ]);
        exit;
    }

    // Collect all other form data except 'project_id' and 'current_step'
    $formData = $_POST;
    unset($formData['project_id'], $formData['current_step']);

    // Get today's date
    $todayDate = date('Y-m-d');

    try {
        // Start the transaction to ensure data consistency
        $conn->beginTransaction();

        // Update query for stage one (set status to 'Completed' and end date to today's date)
        $updateFields = implode(", ", array_map(fn($col) => "$col = ?", array_keys($formData)));
        $updateStageOneQuery = "UPDATE stagetwo 
                                SET status_stage_two = 'Completed', 
                                    end_date_stage_two = ?, 
                                    $updateFields
                                WHERE project_unique_id = ?";
        $stmt = $conn->prepare($updateStageOneQuery);
        $params = array_merge([$todayDate], array_values($formData), [$projectUniqueId]);
        $stmt->execute($params);

        // Check if the update for stage one was successful
        if ($stmt->rowCount() === 0) {
            throw new Exception("No data found to update for stage one.");
        }
        // Insert query for stage two (set status to 'Ongoing' and start date to today's date)
        $insertStageTwoQuery = "INSERT INTO stagethree (project_unique_id, status_stage_three, start_date_stage_three, end_date_stage_three) 
                                VALUES (?, 'Ongoing', ?, 'Not Yet Ended')";
        $stmt = $conn->prepare($insertStageTwoQuery);
        $stmt->execute([$projectUniqueId, $todayDate]);

        // Commit the transaction if both queries were successful
        $conn->commit();

        // Respond with success
        echo json_encode([
            'success' => true,
            'message' => 'Stage one updated to "Completed" and stage two started with "Ongoing".'
        ]);
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();

        // Respond with an error message
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    // Handle unsupported methods
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>
