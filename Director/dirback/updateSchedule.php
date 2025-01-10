<?php
session_start();
header('Content-Type: application/json');

// Include your DB connection file
include('../../auth/db.php'); // Adjust the path as needed

// Read JSON from request body
$input = file_get_contents("php://input");
$data  = json_decode($input, true);

if (!$data) {
    echo json_encode(['error' => true, 'message' => 'Invalid or missing JSON payload']);
    exit;
}

// Extract fields
$schedId = $data['sched_id'] ?? null;
$event   = $data['event']    ?? null;
$start   = $data['start']    ?? null;
$time    = $data['time']     ?? null;
$venue   = $data['venue']    ?? null;

// Confirm the current user
$userId  = $_SESSION['user_id_c'] ?? null;

// Validate required fields
$missingFields = [];
if (!$schedId) $missingFields[] = 'sched_id';
if (!$event)   $missingFields[] = 'event';
if (!$start)   $missingFields[] = 'start';
if (!$time)    $missingFields[] = 'time';
if (!$userId)  $missingFields[] = 'user_id';

if (!empty($missingFields)) {
    echo json_encode([
        'error' => true,
        'message' => 'Missing required fields: ' . implode(', ', $missingFields)
    ]);
    exit;
}

// Prepare the update
try {
    $stmt = $conn->prepare("
        UPDATE schedule_tb
        SET event = :event,
            start = :start,
            time  = :time,
            venue = :venue
        WHERE sched_id = :sched_id
          AND user_id_cur = :user_id
    ");
    $stmt->bindParam(':event',   $event);
    $stmt->bindParam(':start',   $start);
    $stmt->bindParam(':time',    $time);
    $stmt->bindParam(':venue',   $venue);
    $stmt->bindParam(':sched_id', $schedId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id',  $userId,  PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Successfully updated at least one row
        echo json_encode(['error' => false, 'message' => 'Record updated successfully']);
    } else {
        // No rows updated
        echo json_encode(['error' => false, 'message' => 'No rows updated. Check sched_id or user permissions.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => true, 'message' => 'Database error: ' . $e->getMessage()]);
}
