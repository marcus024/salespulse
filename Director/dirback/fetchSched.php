<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php'); 
if (!isset($_GET['sched_id'])) {
    echo json_encode(['error' => true, 'message' => 'Missing sched_id']);
    exit;
}

$scheduleId = $_GET['sched_id'];

$userId = $_SESSION['user_id_c'] ?? 0;

try {
    $stmt = $conn->prepare("
        SELECT sched_id, event, start, time, venue
        FROM schedule_tb
        WHERE sched_id = :sched_id
          AND user_id_cur = :user_id
    ");
    $stmt->bindParam(':sched_id', $scheduleId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id',  $userId,     PDO::PARAM_INT);
    $stmt->execute();

    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($schedule) {
        echo json_encode([
            'error' => false,
            'data'  => $schedule
        ]);
    } else {
        echo json_encode(['error' => true, 'message' => 'No schedule found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
