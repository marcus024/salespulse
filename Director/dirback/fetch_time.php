<?php
include("../../auth/db.php");
session_start();


// Check if user is logged in
if (!isset($_SESSION['user_id_c'])) {
    die(json_encode(["error" => "User not logged in."]));
}

$currentUser = $_SESSION['user_id_c'];

// Query to fetch user-specific task records
$sql = "SELECT work_id, task, project, start_time, end_time FROM workpulse WHERE user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUser);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    error_log("SQL Error: " . $conn->error);
    die(json_encode(["error" => "SQL Error: " . $conn->error]));
}

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $startTime = strtotime($row['start_time']);
    $endTime = strtotime($row['end_time']);

    // Compute duration in HH:MM:SS format
    $durationInSeconds = $endTime - $startTime;
    $hours = floor($durationInSeconds / 3600);
    $minutes = floor(($durationInSeconds % 3600) / 60);
    $seconds = $durationInSeconds % 60;
    $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    $tasks[] = [
        'work_id' => $row['work_id'],
        'task' => $row['task'],
        'project' => $row['project'],
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time'],
        'duration' => $duration
    ];
}

// Return JSON response
echo json_encode($tasks);
?>
