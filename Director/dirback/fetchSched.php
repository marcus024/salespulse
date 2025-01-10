<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php'); // Adjust the path to your DB connection

// Ensure we have a schedule ID from the query string (e.g. ?sched_id=7)
if (!isset($_GET['sched_id'])) {
    echo json_encode(['error' => true, 'message' => 'Missing sched_id']);
    exit;
}

$scheduleId = $_GET['sched_id'];

// Make sure we know who is the current user
$userId = $_SESSION['user_id_c'] ?? 0;

try {
    // Fetch one schedule that belongs to this user
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
