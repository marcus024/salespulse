<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

try {
    // SQL query to fetch time tracker values
    $sql = "SELECT 
                w.work_id,
                w.project AS auxiliary,
                w.start_time,
                w.end_time,
                w.time AS duration,
                s.position AS role
            FROM workpulse AS w
            LEFT JOIN salesauth AS s ON w.user = s.user_id_current";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'data'   => $rows
    ]);
} catch (PDOException $e) {
    http_response_code(500); // Set HTTP response code for error
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
