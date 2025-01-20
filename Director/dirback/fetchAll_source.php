<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php');

// Get the current user's company
$currentCompany = $_SESSION['company'] ?? '';

if (empty($currentCompany)) {
    echo json_encode(['status' => 'error', 'message' => 'User not properly logged in.']);
    exit;
}

try {
    // Fetch sources for the current company
    $sql = "SELECT sourcetype FROM source_tb WHERE company = :company ORDER BY sourcetype ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->execute();

    $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $sources]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
