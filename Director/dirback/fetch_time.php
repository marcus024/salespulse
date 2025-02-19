<?php
include("../../auth/db.php");
session_start();

header("Content-Type: application/json"); // Ensure JSON response

function fetchTaskData() {
    global $conn;

    $sql = "SELECT task, project, start_time, end_time FROM workpulse";
    $result = $conn->query($sql);

    if (!$result) {
        error_log("SQL Error: " . $conn->error); // Log error to server logs
        die(json_encode(["error" => "SQL Error: " . $conn->error]));
    }

    $tasks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert times to timestamps
            $startTime = strtotime($row['start_time']);
            $endTime = strtotime($row['end_time']);

            // Calculate duration in seconds
            $durationInSeconds = $endTime - $startTime;

            // Convert to HH:MM:SS format
            $hours = floor($durationInSeconds / 3600);
            $minutes = floor(($durationInSeconds % 3600) / 60);
            $seconds = $durationInSeconds % 60;
            $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

            $tasks[] = [
                'task' => $row['task'],
                'project' => $row['project'],
                'start' => date("Y-m-d\TH:i:s", $startTime),
                'end' => date("Y-m-d\TH:i:s", $endTime),
                'duration' => $duration // Include computed duration
            ];
        }
    } else {
        return json_encode(["message" => "No tasks found."]);
    }

    return json_encode($tasks);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo fetchTaskData();
}
?>
