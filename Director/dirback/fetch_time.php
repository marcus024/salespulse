<?php
include("../../auth/db.php");
session_start();

header("Content-Type: application/json"); // Ensure JSON response

function fetchTaskData() {
    global $conn;

    $sql = "SELECT * FROM workpulse";
    $result = $conn->query($sql);

    if (!$result) {
        die(json_encode(["error" => "SQL Error: " . $conn->error])); // Debug SQL errors
    }

    $tasks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = [
                'project' => $row['project'],
                'start' => date("Y-m-d\TH:i:s", strtotime($row['start_time'])), // Ensure ISO format
                'end' => date("Y-m-d\TH:i:s", strtotime($row['end_time'])) // Ensure ISO format
            ];
        }
        return json_encode($tasks); // Return fetched data
    } else {
        return json_encode(["message" => "No tasks found."]); // Message when no data is available
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo fetchTaskData();
}
?>
