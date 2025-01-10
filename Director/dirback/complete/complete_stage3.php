<?php
if (isset($_GET['project_id'])) {
    $projectId = $_GET['project_id'];

    // Complete the stage for the project
    // Example: Update the status of the stage in the database
    // $pdo = new PDO(...);  // Database connection
    // $stmt = $pdo->prepare("UPDATE project_data SET status = 'completed' WHERE project_id = ? AND stage = ?");
    // $stmt->execute([$projectId, 1]);

    echo "Stage 3 completed for Project ID {$projectId}.";
} else {
    echo "Project ID missing.";
}
?>
