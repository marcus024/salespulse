<?php
include('../../auth/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['requirementId']) && isset($data['project_id'])) {
        $requirement = $data['requirementId'];
        $project_id = $data['project_id'];

        try {
            $sql = "DELETE FROM requirement_fourtb WHERE requirement_id_4 = :requirement_id AND project_unique_id = :project_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':requirement_id', $requirement, PDO::PARAM_STR);
            $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Requirement deleted successfully.']);
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
