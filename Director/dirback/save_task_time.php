<?php
include("../../auth/db.php");

// Insert task time when stopped
function insertTaskTime($taskName, $project, $user, $startTime, $endTime) {
    global $conn;

    // Format times
    $startTime = date('Y-m-d H:i:s', strtotime($startTime));
    $endTime = date('Y-m-d H:i:s', strtotime($endTime));

    $sql = "INSERT INTO task_time (task, project, user, start_time, end_time) VALUES ('$taskName', '$project', '$user', '$startTime', '$endTime')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskName = $_POST['taskName'];
    $project = $_POST['project'];
    $user = $_POST['user'];  // User info can be fetched from session or input
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    insertTaskTime($taskName, $project, $user, $startTime, $endTime);
}
?>
