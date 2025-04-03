<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Include database connection
require '../../auth/db.php';

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
// if (!isset($data['logged_in'], $data['session_status'], $data['current_users'], $data['device_id'], $data['active_status'])) {
//     echo json_encode(["error" => "Missing required fields"]);
//     exit;
// }

// Assign values with null handling
$logged_in = !empty($data['logged_in']) ? $data['logged_in'] : null;
$logged_out = !empty($data['logged_out']) ? $data['logged_out'] : null;
$session_status = !empty($data['session_status']) ? $data['session_status'] : null;
$current_users = !empty($data['current_users']) ? $data['current_users'] : null;
$last_active = !empty($data['last_active']) ? $data['last_active'] : null;
$device_id = !empty($data['device_id']) ? $data['device_id'] : null;
$active_status = !empty($data['active_status']) ? $data['active_status'] : null;

try {
    // Prepare query
    $stmt = $conn->prepare("
        INSERT INTO sessions (logged_in, logged_out, session_status, current_users, last_active, device_id, active_status) 
        VALUES (:logged_in, :logged_out, :session_status, :current_users, :last_active, :device_id, :active_status)
    ");

    // Execute statement
    $stmt->execute([
        ':logged_in' => $logged_in,
        ':logged_out' => $logged_out,
        ':session_status' => $session_status,
        ':current_users' => $current_users,
        ':last_active' => $last_active,
        ':device_id' => $device_id,
        ':active_status' => $active_status
    ]);

    echo json_encode(["message" => "Session data inserted successfully!"]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Insert failed: " . $e->getMessage()]);
}
?>
