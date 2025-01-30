<?php
session_start();
header('Content-Type: application/json');

// Include the database connection
include('../../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newClientType = trim($_POST['client_type'] ?? '');

    // Validate input
    if (empty($newClientType)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Client Type.']);
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
        // Check if the client type already exists
        $sqlCheck = "SELECT * FROM clienttype_tb WHERE client_type = :client_type";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':client_type', $newClientType, PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Client Type already exists.']);
            exit;
        }

        // Insert new client type
        $sql = "INSERT INTO clienttype_tb (client_type, created_at, user_id, company) VALUES (:client_type, NOW(), :user_id, :company)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':client_type', $newClientType, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_STR);
        $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Client Type added successfully.', 'client_type' => $newClientType]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add Client Type.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
