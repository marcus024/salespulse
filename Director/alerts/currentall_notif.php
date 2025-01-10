<?php
// alerts/current_notif.php
header('Content-Type: application/json');

require_once '../../auth/db.php';

// Get the raw POST data and decode the JSON
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['user_id'] ?? null;

if (!$user_id) {
    http_response_code(400);
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

try {

    // Fetch notifications for the given user ID
    $stmt = $conn->prepare("
        SELECT notif_id, read_status, content, type, related_id, created_at 
        FROM notifications 
        WHERE user_id = :user_id 
        ORDER BY created_at DESC
    ");
    $stmt->execute(['user_id' => $user_id]);

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'notifications' => $notifications]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch notifications', 'details' => $e->getMessage()]);
}
?>
