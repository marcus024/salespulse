<?php
include('../../auth/db.php'); // Include DB connection

header('Content-Type: application/json');

// Validate project_id
if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    try {
        $sql = "SELECT start_date_stage_two, end_date_stage_two, status_stage_two FROM stagetwo WHERE project_unique_id = :project_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'start_date' => $result['start_date_stage_two'],
                'end_date' => $result['end_date_stage_two'],
                'project_status' => $result['status_stage_two']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Project not found.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
}
?>
