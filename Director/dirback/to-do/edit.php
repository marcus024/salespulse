<?php
include('../../../auth/db.php');

// Update task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'], $data['taskname'], $data['assigned_to'], $data['start_date'], $data['end_date'])) {
        $id = intval($data['id']);
        $taskname = $data['taskname'];
        $assigned_to = $data['assigned_to'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        $query = $conn->prepare("UPDATE todo_tb SET taskname = ?, assigned = ?, starttask = ?, endtask = ? WHERE todo_id = ?");
        $query->bind_param("sssii", $taskname, $assigned_to, $start_date, $end_date, $id);

        if ($query->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Task updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update task']);
        }
        $query->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>
