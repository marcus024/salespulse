<?php
include('../../auth/db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id']; // Retrieve project ID sent from the frontend

    try {
        // Query to get the current stage of the project
        $stmt = $conn->prepare("SELECT current_stage FROM projecttb WHERE project_unique_id = :project_id");
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Get the project details
        if ($result) {
            $current_stage = $result['current_stage']; // Store the current stage

            // Send the response back to the frontend
            echo json_encode(['status' => 'success', 'current_stage' => $current_stage]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Project not found']);
        }

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }

    $conn = null; // Close database connection
}
?>
