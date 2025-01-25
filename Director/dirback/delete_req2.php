<?php
include('../../auth/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['requirementId']) && isset($data['project_id'])) {
        $requirement = $data['requirementId'];
        $project_id = $data['project_id'];

        try {
            // Delete the Stage Two requirement
            $sql = "DELETE FROM requirement_twotb WHERE requirement_id_2 = :requirement_id AND project_unique_id = :project_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':requirement_id', $requirement, PDO::PARAM_STR);
            $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Update fetchStatus of Stage One requirement to 1
                $updateSql = "UPDATE requirementone_tb 
                              SET fetchStatus = 1 
                              WHERE requirement_id_1 = :requirement_id AND project_unique_id = :project_id";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(':requirement_id', $requirement, PDO::PARAM_STR);
                $updateStmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
                $updateStmt->execute();

                if ($updateStmt->rowCount() > 0) {
                    echo json_encode(['status' => 'success', 'message' => 'Requirement deleted and fetchStatus updated successfully.']);
                } else {
                    echo json_encode(['status' => 'warning', 'message' => 'Requirement deleted, but fetchStatus was not updated (no matching Stage One requirement).']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Requirement not found or already deleted.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
