<?php
header('Content-Type: application/json');

include('../../auth/db.php'); // Adjust the path to your database connection file

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

$notification_id = $data['notification_id'] ?? null;

if (!$notification_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Notification ID is required']);
    exit;
}

try {

    // Update the notification's read status to 1
    $stmt = $conn->prepare("UPDATE notifications SET read_status = 1 WHERE notif_id = :notification_id");
    $stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Notification successfully updated
        echo json_encode(['success' => true, 'message' => 'Notification marked as read.']);
    } else {
        // No rows updated (e.g., notification ID not found or already read)
        echo json_encode(['success' => false, 'message' => 'Notification not found or already marked as read.']);
    }
} catch (Exception $e) {
    // Handle any database or execution errors
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while marking the notification as read.', 'details' => $e->getMessage()]);
}
?>
