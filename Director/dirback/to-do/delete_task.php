<?php
include '../../../auth/db.php';

// Get the task ID from the request
$id = $_POST['id'] ?? null;

if ($id) {
    try {
        // Prepare the DELETE query
        $stmt = $conn->prepare("DELETE FROM todo_tb WHERE todo_id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Task not found or already deleted.']);
        }
    } catch (PDOException $e) {
        error_log("Error deleting task: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
