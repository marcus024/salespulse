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
    // Retrieve technology list for the current company
    $sql = "
    SELECT 
        CONCAT(
        UCASE(LEFT(technology, 1)), 
        LOWER(SUBSTRING(technology, 2))
        ) AS technology
    FROM technology_tb
    WHERE company = :company
    ORDER BY technology ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->execute();

    $technologies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $technologies]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
