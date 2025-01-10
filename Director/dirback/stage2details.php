<?php
 
if (file_exists("../../auth/db.php")) {
    include("../../auth/db.php");
} else {
    die("Database configuration file not found.");
}

 
$projectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;
$nextStep = isset($_GET['next_step']) ? $_GET['next_step'] : 2; // Default to step 2

 
$stageDetails = null;

if ($projectId) {
    try {
         
        $stmt = $pdo->prepare("SELECT start_date_stage_two, end_date_stage_two, status_stage_two FROM stagetwo WHERE project_id = :project_id AND step = :step");
        $stmt->execute([
            ':project_id' => $projectId,
            ':step' => $nextStep
        ]);

         
        $stageDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
       
        error_log("Query error: " . $e->getMessage());
    }
}
?>
