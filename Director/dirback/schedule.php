<?php
session_start();
header('Content-Type: application/json');

// Include your DB connection file
include('../../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $event   = $_POST['event'] ?? '';
    $venue   = $_POST['venue'] ?? '';
    $start   = $_POST['start'] ?? '';
    $timeVal = $_POST['time']  ?? '';  // <-- renamed for clarity
    $userId  = $_POST['user_id_cur'] ?? null;

    // Basic server-side validation (optional)
    if (empty($event) || empty($venue) || empty($start) || empty($timeVal)) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    try {
        // Prepare the SQL INSERT statement
        $sql = "INSERT INTO schedule_tb (event, venue, start, time, user_id_cur) 
                VALUES (:event, :venue, :start, :time, :user_id)";

        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':event', $event);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':time', $timeVal);      // <-- match :time placeholder
        $stmt->bindParam(':user_id', $userId);

        // Execute
        $stmt->execute();

        // Return success JSON
        echo json_encode([
            'success' => true,
            'message' => 'Schedule inserted successfully.'
        ]);
    } catch (PDOException $e) {
        // Return error JSON
        echo json_encode([
            'success' => false,
            'message' => 'DB Error: ' . $e->getMessage()
        ]);
    }
} else {
    // Handle invalid request methods
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
