<?php
include("../../auth/db.php");
session_start(); // Start the session

// Function to calculate the duration between start and end times
function calculateDuration($startTime, $endTime) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);

    // Calculate the difference in seconds
    $diffInSeconds = $endTime - $startTime;

    // Convert seconds to hours, minutes, and seconds
    $hours = floor($diffInSeconds / 3600);
    $diffInSeconds %= 3600;
    $minutes = floor($diffInSeconds / 60);
    $seconds = $diffInSeconds % 60;

    // Return the duration in HH:MM:SS format
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Insert task time when stopped
function insertTaskTime($taskName, $project, $user, $startTime, $endTime, $duration) {
    global $conn;

    // Format times
    $startTime = date('Y-m-d H:i:s', strtotime($startTime));
    $endTime = date('Y-m-d H:i:s', strtotime($endTime));

    // SQL query to insert the task time along with the computed duration
    $sql = "INSERT INTO workpulse (task, project, user, start_time, end_time, time) 
            VALUES ('$taskName', '$project', '$user', '$startTime', '$endTime', '$duration')";

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
    $user = $_SESSION['user_id_c'];  // User info can be fetched from session or input
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Calculate the duration
    $duration = calculateDuration($startTime, $endTime);

    // Insert the task data along with the duration
    insertTaskTime($taskName, $project, $user, $startTime, $endTime, $duration);
}
?>
