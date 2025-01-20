<?php
session_start();
header('Content-Type: application/json');

// Include the database connection
include('../../auth/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSource = trim($_POST['added_source'] ?? '');

    // Validate input
    if (empty($newSource)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Source.']);
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
        // Check if the source already exists
        $sqlCheck = "SELECT * FROM source_tb WHERE sourcetype = :source_type AND company = :company";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':source_type', $newSource, PDO::PARAM_STR);
        $stmtCheck->bindParam(':company', $currentCompany, PDO::PARAM_STR);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Source already exists.']);
            exit;
        }

        // Insert new source
        $sql = "INSERT INTO source_tb (sourcetype, created_at, user_id, company) VALUES (:source_type, NOW(), :user_id, :company)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':source_type', $newSource, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_STR);
        $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Source added successfully.', 'source_type' => $newSource]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add Source.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
