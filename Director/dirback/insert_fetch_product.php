<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newProduct = trim($_POST['product'] ?? '');

    // Validate input
    if (empty($newProduct)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Product.']);
        exit;
    }

    // Retrieve current user data
    $currentUserId = $_SESSION['user_id_c'] ?? '';
    $currentCompany = $_SESSION['company'] ?? '';

    if (empty($currentUserId) || empty($currentCompany)) {
        echo json_encode(['status' => 'error', 'message' => 'User not properly logged in.']);
        exit;
    }

    try {
        // Check if the product already exists
        $sqlCheck = "SELECT * FROM product_tb WHERE product = :product AND company = :company";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':product', $newProduct, PDO::PARAM_STR);
        $stmtCheck->bindParam(':company', $currentCompany, PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Product already exists.']);
            exit;
        }

        // Insert new product
        $sql = "INSERT INTO product_tb (product, created_at, user_id, company) VALUES (:product, NOW(), NULL, :company)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product', $newProduct, PDO::PARAM_STR);
        $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Product added successfully.', 'product' => $newProduct]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add Product.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
