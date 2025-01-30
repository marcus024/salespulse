<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php');

// Get current user's company from session
$currentCompany = $_SESSION['company'] ?? '';

if (empty($currentCompany)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not properly logged in.'
    ]);
    exit;
}

try {
    // Retrieve distributor list for current company; ordering alphabetically
    $sql = "SELECT * FROM distributor  ORDER BY distrubutor ASC";
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->execute();
    
    $distributors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'data'   => $distributors
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
