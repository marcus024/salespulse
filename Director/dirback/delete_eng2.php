<?php
include('../../auth/db.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (empty($data['engagementId']) || empty($data['project_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing input parameters.']);
        exit;
    }

    $engagement = htmlspecialchars($data['engagementId'], ENT_QUOTES, 'UTF-8');
    $project_id = htmlspecialchars($data['project_id'], ENT_QUOTES, 'UTF-8');

    try {
        $sql = "DELETE FROM engagement_twotb WHERE engagement_id_2 = :engagement_id AND project_unique_id = :project_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':engagement_id', $engagement, PDO::PARAM_STR);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        // Check result and return response
        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Engagement deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Engagement not found or already deleted.']);
        }
    } catch (PDOException $e) {
        // Log error for debugging
        error_log('Database error: ' . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An internal error occurred while processing your request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Only POST requests are allowed.']);
}
