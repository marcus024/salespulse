<?php
session_start();
include('../../../auth/db.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if session user ID is set
if (!isset($_SESSION['user_id_c']) || empty($_SESSION['user_id_c'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

// Get data from POST request
$actual_com = $_POST['actual_com'];
$target_com = $_POST['target_com'];
$potential_com = $_POST['potential_com'];
$account_manager = $_SESSION['user_id_c'];
$created_at = date('Y-m-d H:i:s');  // Current timestamp

// Prepare SQL Insert query to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO potentialCom (actual_com, target_com, account_manager, potential_com, created_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $actual_com, $target_com, $account_manager, $potential_com, $created_at);

// Execute query and respond
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
