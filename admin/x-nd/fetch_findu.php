<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

// ✅ Restrict access to authenticated users
if (!isset($_SESSION['user_id_c'])) {
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
