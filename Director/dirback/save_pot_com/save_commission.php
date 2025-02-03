<?php
session_start();
include('../../../auth/db.php');
// Get data from POST request
$actual_com = $_POST['actual_com'];
$target_com = $_POST['target_com'];
$potential_com = $_POST['potential_com'];
$account_manager =  $_SESSION['user_id_c'];
$created_at = date('Y-m-d H:i:s');  // Current timestamp

// SQL Insert query
$sql = "INSERT INTO potentialCom (actual_com, target_com, account_manager, created_at)
        VALUES ('$actual_com', '$target_com', '$account_manager', '$created_at')";

// Execute query and respond
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}

// Close connection
$conn->close();
?>
