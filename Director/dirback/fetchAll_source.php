<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php');

// Get current user's company
$currentCompany = $_SESSION['company'] ?? '';

if (empty($currentCompany)) {
    echo json_encode(['status' => 'error', 'message' => 'User not properly logged in.']);
    exit;
}

try {
    // Retrieve client type list for the current company
    $sql = "SELECT sourcetype FROM source_tb WHERE company = :company ORDER BY sourcetype ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->execute();

    $clientTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $clientTypes]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
