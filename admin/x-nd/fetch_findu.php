<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

// Secure API Key (Store securely)
$valid_api_key = 'UAS-SALESPULSE-USER-6';

// Get API Key from request
$provided_api_key = $_GET['api_key'] ?? '';

if ($provided_api_key !== $valid_api_key) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized access'
    ]);
    exit;
}

try {
    $sql = "SELECT * FROM sessions";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Encode and send the response securely
    echo json_encode([
        'status' => 'success',
        'data'   => $rows
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error'
    ]);
}
?>
