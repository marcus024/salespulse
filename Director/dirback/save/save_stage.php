<?php
// Database connection
require '../../../auth/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve posted data
    $projectUniqueId = $_POST['project_id'] ?? null;
    $currentStep = $_POST['current_step'] ?? null;

    if (!$projectUniqueId || !$currentStep) {
    error_log("Missing parameters: Project ID = $projectUniqueId, Current Step = $currentStep");
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit;
}

    // Validate required fields
    if (!$projectUniqueId || !$currentStep) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
        exit;
    }

    try {
        // Check the current step
        if ($currentStep == 1) {
            // Retrieve general table data
            $solution = $_POST['solution'] ?? null;
            $technology = $_POST['technology'] ?? null;
            $dealSize = $_POST['deal_size'] ?? null;
            $distributor = $_POST['distributor'] ?? null;
            $remarks = $_POST['stage_one_remarks'] ?? null;
            $product = $_POST['product'] ?? null;
            $status = $_POST['status_stage_one'] ?? null;
            $startDate = $_POST['start_date_stage_one'] ?? null;
            $endDate = $_POST['end_date_stage_one'] ?? null;

            // Retrieve and decode requirements (JSON format)
            $requirements = json_decode($_POST['requirements'] ?? '[]', true);

            // Begin transaction
            $conn->beginTransaction();

            // Insert requirements into requirementone_tb
            $requirementId = null;
            if (!empty($requirements)) {
                $stmt = $conn->prepare("INSERT INTO requirementone_tb (stageone_id, requirements) VALUES (?, ?)");
                foreach ($requirements as $requirement) {
                    $stmt->execute([null, $requirement]);
                }
                $requirementId = $conn->lastInsertId();
            }

            // Update data in stageone table
            $stmt = $conn->prepare(
                "UPDATE stageone
                SET 
                    solution = ?, 
                    technology = ?, 
                    deal_size = ?, 
                    distributor = ?, 
                    stage_one_remarks = ?, 
                    product = ?, 
                    status_stage_one = ?, 
                    start_date_stage_one = ?, 
                    end_date_stage_one = ?, 
                    requirement_id_one = ?
                WHERE 
                    project_unique_id = ?"
            );

            $stmt->execute([
                $solution, $technology, $dealSize, $distributor,
                $remarks, $product, $status, $startDate, $endDate, 
                $requirementId, $projectUniqueId
            ]);

            // Commit transaction
            $conn->commit();

            echo json_encode(['success' => true, 'message' => 'Data saved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid step for this operation.']);
        }
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
