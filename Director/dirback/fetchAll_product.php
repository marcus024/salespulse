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
    // Retrieve product list for the current company
    $sql = "SELECT * FROM product_tb  ORDER BY product ASC";
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $products]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
