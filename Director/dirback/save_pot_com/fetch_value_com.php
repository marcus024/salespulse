<?php
// fetch_calculation.php

session_start();
include('../../../auth/db.php');

// Function to fetch the latest calculation
function fetchLatestCalculation($conn) {
    // SQL query to fetch the latest calculation by creation date
    $sql = "SELECT * FROM potentialCom ORDER BY created_at DESC LIMIT 1";
    $result = $conn->query($sql);
    
    // Check if the result contains a row
    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();
        
        // Return the relevant data
        return [
            'actual_com' => $row['actual_com'],
            'target_com' => $row['target_com'],
            'potential_com' => $row['potential_com'],
            'created_at' => $row['created_at']
        ];
    } else {
        return null;
    }
}

// Fetch the latest calculation
$latestCalculation = fetchLatestCalculation($conn);

// Check if data is found
if ($latestCalculation) {
    echo json_encode([
        'status' => 'success',
        'actual_com' => $latestCalculation['actual_com'],
        'target_com' => $latestCalculation['target_com'],
        'potential_com' => $latestCalculation['potential_com'],
        'created_at' => $latestCalculation['created_at']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No data found'
    ]);
}

$conn->close();
?>
