<?php
// Include the database configuration file
if (file_exists("../../auth/db.php")) {
    include("../../auth/db.php");
} else {
    die("Database configuration file not found.");
}

// Assuming $pdo is already initialized and represents your database connection

// Replace `project_id` and `next_step` with actual variables passed via GET or POST
$projectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;
$nextStep = isset($_GET['next_step']) ? $_GET['next_step'] : 2; // Default to step 2

// Initialize $stageDetails
$stageDetails = null;

if ($projectId) {
    try {
        // Query to fetch stage details
        $stmt = $pdo->prepare("SELECT start_date_stage_two, end_date_stage_two, status_stage_two FROM stagetwo WHERE project_id = :project_id AND step = :step");
        $stmt->execute([
            ':project_id' => $projectId,
            ':step' => $nextStep
        ]);

        // Fetch the result
        $stageDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle query error
        error_log("Query error: " . $e->getMessage());
    }
}
?>
