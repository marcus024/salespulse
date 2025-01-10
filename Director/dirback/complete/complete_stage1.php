<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
    exit;
}

try {
    // Include the database configuration
    include("../../../auth/db.php");

    // Collect and validate required fields
    $projectUniqueId = $_POST['project_id'] ?? null;
    $currentStep = $_POST['current_step'] ?? null;

    if (!$projectUniqueId) {
        throw new Exception("Missing required field: project_id.");
    }
    if (!$currentStep) {
        throw new Exception("Missing required field: current_step.");
    }

    // Collect additional form data
    $formData = $_POST;
    unset($formData['project_id'], $formData['current_step']);

    // Get today's date
    $todayDate = date('Y-m-d');

    // Begin transaction for consistency
    $conn->beginTransaction();

    // Prepare and execute the UPDATE query for stage one
    $updateFields = implode(", ", array_map(fn($col) => "$col = ?", array_keys($formData)));
    $updateStageOneQuery = "UPDATE stageone 
                            SET status_stage_one = 'Completed', 
                                end_date_stage_one = ?, 
                                $updateFields 
                            WHERE project_unique_id = ?";
    $updateParams = array_merge([$todayDate], array_values($formData), [$projectUniqueId]);
    $stmt = $conn->prepare($updateStageOneQuery);
    $stmt->execute($updateParams);

    // Check if any rows were updated
    if ($stmt->rowCount() === 0) {
        throw new Exception("No records updated in stageone. Check if project_id exists.");
    }

    // Prepare and execute the INSERT query for stage two
    $insertStageTwoQuery = "INSERT INTO stagetwo (project_unique_id, status_stage_two, start_date_stage_two, end_date_stage_two) 
                            VALUES (?, 'Ongoing', ?, 'Not Yet Ended')";
    $stmt = $conn->prepare($insertStageTwoQuery);
    $stmt->execute([$projectUniqueId, $todayDate]);

    // Check if the insertion was successful
    if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to insert into stagetwo. Check if project_id exists.");
    }

    // Update the current_stage in projecttb to 'stage 2'
    $updateProjectStageQuery = "UPDATE projecttb 
                                SET current_stage = 'Stage 2' 
                                WHERE project_unique_id = ?";
    $stmt = $conn->prepare($updateProjectStageQuery);
    $stmt->execute([$projectUniqueId]);

    // Check if the projecttb update was successful
    if ($stmt->rowCount() === 0) {
        throw new Exception("Failed to update the current_stage in projecttb. Check if project_id exists.");
    }

    // Select query to fetch the details from stagetwo
    $selectStageTwoQuery = "SELECT start_date_stage_two, end_date_stage_two, status_stage_two 
                            FROM stagetwo 
                            WHERE project_unique_id = ?";
    $stmt = $conn->prepare($selectStageTwoQuery);
    $stmt->execute([$projectUniqueId]);

    // Check if data was fetched successfully
    if ($stmt->rowCount() > 0) {
        $stageTwoDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        throw new Exception("No data found for the given project ID in stagetwo.");
    }

    // Commit the transaction
    $conn->commit();

    // Respond with success and the fetched details
    echo json_encode([
        'success' => true,
        'message' => 'Stage one updated to "Completed", stage two started with "Ongoing", and project stage updated to "stage 2".',
        'stage_two_details' => $stageTwoDetails
    ]);

} catch (Exception $e) {
    // Rollback transaction in case of error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    // Log error for debugging
    error_log("Error in processing request: " . $e->getMessage());

    // Respond with error
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
