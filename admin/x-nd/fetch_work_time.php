<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

try {
    // Fetch all records from workpulse
    $sql = "SELECT * FROM workpulse";
    
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
