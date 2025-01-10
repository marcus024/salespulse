<?php
include('../../../auth/db.php');
header('Content-Type: application/json'); // Ensure JSON response

error_log(print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['todo_id']) ? intval($_POST['todo_id']) : null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'Task ID is required.']);
        exit;
    }

    // Prepare an array for dynamic query parts
    $fieldsToUpdate = [];
    $params = [];

    if (isset($_POST['taskname']) && !empty($_POST['taskname'])) {
        $fieldsToUpdate[] = "taskname = :taskname";
        $params[':taskname'] = $_POST['taskname'];
    }
    if (isset($_POST['assigned']) && !empty($_POST['assigned'])) {
        $fieldsToUpdate[] = "assigned = :assigned";
        $params[':assigned'] = $_POST['assigned'];
    }
    if (isset($_POST['starttask']) && !empty($_POST['starttask'])) {
        $fieldsToUpdate[] = "starttask = :starttask";
        $params[':starttask'] = $_POST['starttask'];
    }
    if (isset($_POST['endtask']) && !empty($_POST['endtask'])) {
        $fieldsToUpdate[] = "endtask = :endtask";
        $params[':endtask'] = $_POST['endtask'];
    }

    // If no fields to update, return an error
    if (empty($fieldsToUpdate)) {
        echo json_encode(['success' => false, 'message' => 'No valid fields to update.']);
        exit;
    }

    // Add the ID to the parameters
    $params[':id'] = $id;

    // Build the dynamic SQL query
    $sql = "UPDATE todo_tb SET " . implode(", ", $fieldsToUpdate) . " WHERE todo_id = :id";

    try {
        $query = $conn->prepare($sql);

        // Bind parameters dynamically
        foreach ($params as $param => $value) {
            $query->bindValue($param, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        if ($query->execute()) {
            echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the task.', 'error' => $query->errorInfo()]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error.', 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
