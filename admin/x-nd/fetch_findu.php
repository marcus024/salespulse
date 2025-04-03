<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

try {
    // SQL query to fetch all values from sessions table
    $sql = "SELECT * FROM sessions";

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
