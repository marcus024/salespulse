<?php
session_start();
header('Content-Type: application/json');

// Include your database connection
include('../../auth/db.php');

// Get the current user's ID and company from session
$currentUserId = $_SESSION['user_id_c'] ?? '';  

if (empty($currentUserId)) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

try {
    $sql = "SELECT project_unique_id, company_name 
            FROM projecttb 
            WHERE user_id_cur = :user_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_STR);
    $stmt->execute();
    
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data'   => $projects
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
