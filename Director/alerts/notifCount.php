<?php
include('../../auth/db.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    // Parse request data
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['notification_id']) || !isset($input['user_id'])) {
        throw new Exception("Notification ID and User ID are required.");
    }

    $notification_id = $input['notification_id'];
    $user_id = $input['user_id'];

    // Debugging: Log incoming data
    error_log("Notification ID: $notification_id, User ID: $user_id");

    // Update notification in the database
    $update_sql = "
        UPDATE notifications 
        SET read_status = 1 
        WHERE related_id = :notification_id AND user_id = :user_id
    ";
    $stmt = $conn->prepare($update_sql);
    $stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        // Debugging: Check if the record exists
        $debug_stmt = $conn->prepare("
            SELECT * FROM notifications 
            WHERE related_id = :notification_id AND user_id = :user_id
        ");
        $debug_stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_STR);
        $debug_stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $debug_stmt->execute();
        $debug_results = $debug_stmt->fetch(PDO::FETCH_ASSOC);

        error_log("Debugging Query Results: " . print_r($debug_results, true));
        throw new Exception("No rows updated. Notification may not exist or is already read.");
    }

    // Count unread notifications for the current user
    $count_sql = "
        SELECT COUNT(*) AS unread_count 
        FROM notifications 
        WHERE user_id = :user_id AND read_status = 0
    ";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $count_stmt->execute();

    $unread_count = $count_stmt->fetch(PDO::FETCH_ASSOC)['unread_count'];

    // Fetch and return the updated record
    $select_sql = "
        SELECT related_id, user_id, read_status 
        FROM notifications 
        WHERE related_id = :notification_id AND user_id = :user_id
    ";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_STR);
    $select_stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $select_stmt->execute();

    $updated_record = $select_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$updated_record) {
        throw new Exception("Failed to retrieve the updated notification record.");
    }

    echo json_encode([
        'success' => true,
        'updated_record' => $updated_record,
        'unread_count' => $unread_count,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    error_log("Error updating notification: " . $e->getMessage());
    echo json_encode(['error' => $e->getMessage()]);
}
?>
