<?php
// insertDistributor.php

session_start();

// Set response type
header('Content-Type: application/json');

// Include the database connection
include('../../auth/db.php');

// Ensure the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate the posted distributor name
    if (isset($_POST['distributor']) && !empty(trim($_POST['distributor']))) {
        $newDistributor = trim($_POST['distributor']);

        // Retrieve the current user's ID and company from the session
        $currentUserId   = $_SESSION['user_id_c']   ?? '';
        $currentCompany  = $_SESSION['company']   ?? '';

        if (empty($currentUserId) || empty($currentCompany)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'User not properly logged in.'
            ]);
            exit;
        }

        try {
            // Optional: Check if the distributor already exists for this company
            $sqlCheck = "SELECT * FROM distrubutor WHERE distrubutor = :distrubutor AND company = :company";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':distrubutor', $newDistributor, PDO::PARAM_STR);
            $stmtCheck->bindParam(':company', $currentCompany, PDO::PARAM_STR);
            $stmtCheck->execute();

            if ($stmtCheck->rowCount() > 0) {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Distributor already exists.'
                ]);
                exit;
            }

            // Insert the new distributor into the 'distrubutor' table
            $sql = "INSERT INTO distrubutor (distrubutor, created_at, user_id, company) 
                    VALUES (:distrubutor, NOW(), :user_id, :company)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':distrubutor', $newDistributor, PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_STR);
            $stmt->bindParam(':company', $currentCompany, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo json_encode([
                    'status'      => 'success',
                    'message'     => 'Distributor added successfully.',
                    'distributor' => $newDistributor
                ]);
            } else {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Could not add distributor. Please try again.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Invalid distributor value provided.'
        ]);
    }
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Invalid request method. Use POST.'
    ]);
}
