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

// Prepare the query with PDO
$sql = "INSERT INTO potentialCom (actual_com, target_com, account_manager, potential_com, created_at)
        VALUES (:actual_com, :target_com, :account_manager, :potential_com, :created_at)";
$stmt = $conn->prepare($sql);

// Bind parameters using PDO's bindParam
$stmt->bindParam(':actual_com', $actual_com);
$stmt->bindParam(':target_com', $target_com);
$stmt->bindParam(':account_manager', $account_manager);
$stmt->bindParam(':potential_com', $potential_com);
$stmt->bindParam(':created_at', $created_at);

// Execute the query and respond
if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->errorInfo()[2]]);
}

$stmt = null;
$conn = null;
?>
