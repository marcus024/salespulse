<?php
session_start(); 
header('Content-Type: application/json');

// 1. Include your database connection
include('../../auth/db.php');

// 2. Get the current user's company from session or however you store it
$currentUserCompany = $_SESSION['company'] ?? '';

// Check if user is logged in or if $currentUserCompany is valid, etc.

// 3. Prepare and execute the query
try {
    $sql = "SELECT 
                s.id,
                s.firstname,
                s.lastname,
                s.company,
                s.user_id_current,
                s.image,
                p.peak_id,
                p.peak_user,
                p.logged_in
            FROM salesauth AS s
            JOIN peak_tb AS p 
              ON s.user_id_current = p.peak_user
            WHERE s.company = :company";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentUserCompany, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Send JSON response
    echo json_encode([
        'status' => 'success',
        'data'   => $rows
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
