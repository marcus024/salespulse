<?php
include("../../auth/db.php");
session_start();

header("Content-Type: application/json"); // Ensure JSON response

function fetchTaskData() {
    global $conn;

    // Get current logged-in user from session
    if (!isset($_SESSION['user_id_c'])) {
        die(json_encode(["error" => "User not logged in."]));
    }

    $currentUser = $_SESSION['user_id_c'];

    // Fetch tasks only for the logged-in user
    $sql = "SELECT task, project, start_time, end_time FROM workpulse WHERE user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        error_log("SQL Error: " . $conn->error);
        die(json_encode(["error" => "SQL Error: " . $conn->error]));
    }

    $tasks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $startTime = strtotime($row['start_time']);
            $endTime = strtotime($row['end_time']);

            // Calculate duration in HH:MM:SS format
            $durationInSeconds = $endTime - $startTime;
            $hours = floor($durationInSeconds / 3600);
            $minutes = floor(($durationInSeconds % 3600) / 60);
            $seconds = $durationInSeconds % 60;
            $duration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

            $tasks[] = [
                'task' => $row['task'],
                'project' => $row['project'],
                'start' => date("Y-m-d\TH:i:s", $startTime),
                'end' => date("Y-m-d\TH:i:s", $endTime),
                'duration' => $duration
            ];
        }
    } else {
        return json_encode(["message" => "No tasks found for the current user."]);
    }

    return json_encode($tasks);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo fetchTaskData();
}
?>
