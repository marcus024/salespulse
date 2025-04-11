<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

$valid_api_key = '123#';

// Get headers
$headers = getallheaders();
$provided_api_key = isset($headers['X-API-KEY']) ? $headers['X-API-KEY'] : null;

// Check API key
if ($provided_api_key !== $valid_api_key) {
    http_response_code(401); // Unauthorized
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized - invalid API key'
    ]);
    exit;
}

try {
    $sql = "SELECT * FROM sessions";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Securely return the response
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
