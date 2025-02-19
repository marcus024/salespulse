<?php
include("../../auth/db.php");
session_start();

// Debugging: Check if session is set
if (!isset($_SESSION['user_id_c'])) {
    die(json_encode(["error" => "User not logged in."]));
}

$currentUser = $_SESSION['user_id_c'];

try {
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT work_id, task, time, project, start_time, end_time FROM workpulse WHERE user = :user");
    $stmt->bindParam(":user", $currentUser, PDO::PARAM_STR);
    $stmt->execute();
    
    // Fetch all records
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add duration computation
    foreach ($tasks as &$task) {
        $startTime = strtotime($task['start_time']);
        $endTime = strtotime($task['end_time']);
        $task['duration'] = gmdate("H:i:s", $endTime - $startTime);
    }

    echo json_encode($tasks);
} catch (PDOException $e) {
    echo json_encode(["error" => "Query failed: " . $e->getMessage()]);
}
?>
