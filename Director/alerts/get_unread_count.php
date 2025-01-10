<?php
// get_unread_count.php

header('Content-Type: application/json');

// You could use a session, but for demonstration, we’ll rely on the GET parameter.
if (!isset($_GET['user_id'])) {
    echo json_encode(["unread_count" => 0]);
    exit;
}

// user_id is a string, so no integer cast here
$user_id = $_GET['user_id'];

try {
    include('../../auth/db.php');

    // Query using the string user_id in the WHERE clause
    $query = $conn->prepare("
        SELECT COUNT(*) AS unread_count
        FROM notifications
        WHERE read_status = 0
          AND user_id = :user_id
    ");
    // Bind as a string
    $query->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    // Return the count as JSON
    echo json_encode(["unread_count" => (int)$row['unread_count']]);
} catch (PDOException $e) {
    // In production, handle error properly.
    echo json_encode(["unread_count" => 0]);
}
