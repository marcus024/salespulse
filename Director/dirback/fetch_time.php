<?php
include("../../auth/db.php");
session_start();

header("Content-Type: application/json"); // Ensure JSON response

function fetchTaskData() {
    global $conn;

    $sql = "SELECT project, start_time, end_time FROM workpulse";
    $result = $conn->query($sql);

    if (!$result) {
        die(json_encode(["error" => "SQL Error: " . $conn->error])); // Debugging SQL errors
    }

    if ($result->num_rows === 0) {
        die(json_encode(["message" => "No tasks found, but query executed successfully."]));
    }

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            'project' => $row['project'],
            'start' => date("Y-m-d\TH:i:s", strtotime($row['start_time'])), // Ensure ISO format
            'end' => date("Y-m-d\TH:i:s", strtotime($row['end_time'])) // Ensure ISO format
        ];
    }

    return json_encode($tasks); // Return actual data
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo fetchTaskData();
}
?>
