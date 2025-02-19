<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

// Get the current user's department from session
$currentUserDept = $_SESSION['role'] ?? '';

try {
    // SQL query to fetch time tracker values
    $sql = "SELECT 
                w.work_id AS work_id,
                w.task AS auxiliary,
                w.start_time,
                w.end_time,
                w.time AS duration
            FROM workpulse AS w
            JOIN salesauth AS s ON w.user = s.user_id_current";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'data'   => $rows
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
