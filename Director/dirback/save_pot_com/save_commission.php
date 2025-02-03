<?php
session_start();
include('../../../auth/db.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get data from POST request
$actual_com = $_POST['actual_com'];
$target_com = $_POST['target_com'];
$potential_com = $_POST['potential_com'];
$account_manager =  $_SESSION['user_id_c'];
$created_at = date('Y-m-d H:i:s');  // Current timestamp

// Prepare and bind the query to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO potentialCom (actual_com, target_com, account_manager, potential_com, created_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $actual_com, $target_com, $account_manager, $potential_com, $created_at);

// Execute the query and respond
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
