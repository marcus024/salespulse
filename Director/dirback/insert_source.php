<?php
session_start();
header('Content-Type: application/json');
include('../../auth/db.php');

$currentCompany = $_SESSION['company'] ?? '';

if (empty($currentCompany)) {
    echo json_encode(['status' => 'error', 'message' => 'User not properly logged in.']);
    exit;
}

$projectId = $_POST['project_id'] ?? '';
$source = $_POST['source'] ?? '';

if (empty($projectId) || empty($source)) {
    echo json_encode(['status' => 'error', 'message' => 'Project ID or source missing.']);
    exit;
}

try {
    // Insert the new source into the database
    $sql = "INSERT INTO source_tb (company, sourcetype, project_id) VALUES (:company, :source, :project_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);
    $stmt->bindParam(':source', $source, PDO::PARAM_STR);
    $stmt->bindParam(':project_id', $projectId, PDO::PARAM_STR);

    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Source added successfully.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
