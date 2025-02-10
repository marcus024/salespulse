<?php
include("../../auth/db.php");
session_start();

function fetchTaskData() {
    global $conn;

    // SQL query to fetch task data
    $sql = "SELECT task, project, start_time, end_time FROM workpulse";
    $result = $conn->query($sql);

    $tasks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = [
                'task' => $row['task'],
                'project' => $row['project'],
                'start' => $row['start_time'],
                'end' => $row['end_time']
            ];
        }
    }

    return json_encode($tasks); // Return as JSON
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo fetchTaskData();  // Fetch and return task data
}
?>
