<?php
include('../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date']; 
    $project_id = $_POST['project_id']; 

    // Debugging: log the values of start_date and project_id
    error_log("Received start_date: $start_date, project_id: $project_id");

    try {
        // Check if the project exists
        $stmt = $conn->prepare("SELECT * FROM projecttb WHERE project_unique_id = :project_id");
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        // Debugging: Check how many rows were found for the project
        error_log("Rows found for project: " . $stmt->rowCount());

        // If project does not exist
        if ($stmt->rowCount() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Project not found or access denied.']);
            exit();
        }

        // Proceed with the update in projecttb
        $stmt = $conn->prepare("
            UPDATE projecttb 
            SET 
                start_date = :start_date, 
                status = 'Ongoing',
                current_stage = 'Stage 1'
            WHERE project_unique_id = :project_id
        ");
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Insert into stageone_tb for phase 1
            $end_date = 'Not Yet Ended';
            $status_stage_one = 'Ongoing';
            $stmt = $conn->prepare("
                INSERT INTO stageone (start_date_stage_one, end_date_stage_one, status_stage_one, project_unique_id)
                VALUES (:start_date_stage_one, :end_date_stage_one, :status_stage_one, :project_unique_id)
            ");
            $stmt->bindParam(':start_date_stage_one', $start_date, PDO::PARAM_STR);
            $stmt->bindParam(':end_date_stage_one', $end_date, PDO::PARAM_STR);
            $stmt->bindParam(':status_stage_one', $status_stage_one, PDO::PARAM_STR);
            $stmt->bindParam(':project_unique_id', $project_id, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $status = 'Ongoing';
                $message = "You've officially started the project journey!";
            } else {
                $status = 'failed';
                $message = "Failed to insert phase 1 details.";
            }
        } else {
            $status = 'failed';
            $message = "Failed to update start date, status, and current stage.";
        }

        // Return the updated status to the frontend
        echo json_encode(['status' => $status, 'message' => $message, 'project_status' => $status]);

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }

    $conn = null;
}
?>
