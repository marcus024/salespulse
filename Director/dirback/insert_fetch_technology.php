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
    // Validate the technology name
    $newTechnology = trim($_POST['added_technology'] ?? '');
    if (empty($newTechnology)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Technology.']);
        exit;
    }

    // Retrieve current user data
    $currentUserId = $_SESSION['user_id_c'] ?? '';

    if (empty($currentUserId)) {
        echo json_encode(['status' => 'error', 'message' => 'User not properly logged in.']);
        exit;
    }

    // Check if the technology already exists
    $sqlCheck = "SELECT * FROM technology_tb WHERE technology = :technology AND company = :company";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bindParam(':technology', $newTechnology, PDO::PARAM_STR);
    $stmtCheck->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Technology already exists.']);
        exit;
    }

    // Insert new technology
    $sql = "INSERT INTO technology_tb (technology, created_at, user_id, company) VALUES (:technology, NOW(), :user_id, :company)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':technology', $newTechnology, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_STR);
    $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Technology added successfully.', 'added_technology' => $newTechnology]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add Technology.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
