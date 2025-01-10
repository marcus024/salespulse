<?php
include('../../../auth/db.php');

// Fetch task by ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT taskname, assigned, starttask, endtask FROM todo_tb WHERE todo_id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $task]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Task not found']);
    }
    $query->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}


?>
