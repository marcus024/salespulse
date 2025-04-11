<?php
session_start();
header('Content-Type: application/json');

// Include database connection
include('../../auth/db.php');

// ✅ Check if user is logged in
// if (!isset($_SESSION['user_id_c'])) {
//     echo json_encode([
//         'status' => 'error',
//         'message' => 'Unauthorized access'
//     ]);
//     exit;
// }

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
