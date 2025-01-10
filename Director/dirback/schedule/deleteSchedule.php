<?php
// Include database connection
include '../../../auth/db.php'; // Update the path to your database connection file

// Allow only DELETE requests
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Get the schedule ID
$scheduleId = htmlspecialchars($_GET['schedule_id'] ?? '');

if (!$scheduleId) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Schedule ID is required']);
    exit;
}

try {
    // Delete the schedule
    $stmt = $conn->prepare("DELETE FROM schedule_tb WHERE sched_id = :schedule_id");
    $stmt->bindParam(':schedule_id', $scheduleId, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the schedule was deleted
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Schedule not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
