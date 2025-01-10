<?php
include('../../auth/db.php');
session_start();

header('Content-Type: application/json');

$user_id = $_SESSION['user_id_c'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['notifications']) || !is_array($input['notifications'])) {
        throw new Exception("Invalid notifications data.");
    }

    $notifications = $input['notifications'];

    // Prepare queries
    $checkSql = "SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND type = :type AND related_id = :related_id";
    $insertSql = "INSERT INTO notifications (user_id, content, type, related_id, created_at) 
                  VALUES (:user_id, :content, :type, :related_id, NOW())";

    $checkStmt = $conn->prepare($checkSql);
    $insertStmt = $conn->prepare($insertSql);

    foreach ($notifications as $notif) {
        // Check if the notification already exists
        $checkStmt->bindParam(':user_id', $notif['user_id'], PDO::PARAM_STR);
        $checkStmt->bindParam(':type', $notif['type'], PDO::PARAM_STR);
        $checkStmt->bindParam(':related_id', $notif['related_id'], PDO::PARAM_STR);
        $checkStmt->execute();

        $exists = $checkStmt->fetchColumn();
        if ($exists == 0) {
            // If not exists, insert the notification
            $insertStmt->bindParam(':user_id', $notif['user_id'], PDO::PARAM_STR);
            $insertStmt->bindParam(':content', $notif['content'], PDO::PARAM_STR);
            $insertStmt->bindParam(':type', $notif['type'], PDO::PARAM_STR);
            $insertStmt->bindParam(':related_id', $notif['related_id'], PDO::PARAM_STR);
            $insertStmt->execute();
        }
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
