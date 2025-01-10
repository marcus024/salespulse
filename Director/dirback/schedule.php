<?php
session_start();
header('Content-Type: application/json');

 
include('../../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
    $event   = $_POST['event'] ?? '';
    $venue   = $_POST['venue'] ?? '';
    $start   = $_POST['start'] ?? '';
    $timeVal = $_POST['time']  ?? '';  // <-- renamed for clarity
    $userId  = $_POST['user_id_cur'] ?? null;

     
    if (empty($event) || empty($venue) || empty($start) || empty($timeVal)) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    try {
         
        $sql = "INSERT INTO schedule_tb (event, venue, start, time, user_id_cur) 
                VALUES (:event, :venue, :start, :time, :user_id)";

        $stmt = $conn->prepare($sql);

        
        $stmt->bindParam(':event', $event);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':time', $timeVal);      // <-- match :time placeholder
        $stmt->bindParam(':user_id', $userId);

         
        $stmt->execute();

        
        echo json_encode([
            'success' => true,
            'message' => 'Schedule inserted successfully.'
        ]);
    } catch (PDOException $e) {
         
        echo json_encode([
            'success' => false,
            'message' => 'DB Error: ' . $e->getMessage()
        ]);
    }
} else {
     
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
