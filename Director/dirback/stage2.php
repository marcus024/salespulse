<?php
include('../../auth/db.php'); // Include DB connection

header('Content-Type: application/json');

// Validate project_id and stage
if (isset($_GET['project_id']) && !empty($_GET['project_id']) && isset($_GET['stage']) && !empty($_GET['stage'])) {
    $project_id = $_GET['project_id'];
    $stage = $_GET['stage']; // Get the stage dynamically

    try {
        // Prepare the SQL query based on the dynamic stage
        // This assumes that the stage number is part of the database field names
        // Example: stage_one, stage_two, etc.
        $sql = "SELECT start_date_stage_{$stage}, end_date_stage_{$stage}, status_stage_{$stage} 
                FROM stagetwo WHERE project_unique_id = :project_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'start_date' => $result["start_date_stage_{$stage}"],
                'end_date' => $result["end_date_stage_{$stage}"],
                'project_status' => $result["status_stage_{$stage}"]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Project not found.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Project ID and Stage are required.']);
}
?>
