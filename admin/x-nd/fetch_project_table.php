<?php
session_start();
header('Content-Type: application/json');

// Include your database connection
include('../../auth/db.php');

try {
    // Get the company from the request or fallback to session
    $currentUserCompany = $_GET['company'] ?? $_SESSION['company'] ?? '';

    // If company is missing, return an error
    if (empty($currentUserCompany)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Company parameter is required.'
        ]);
        exit;
    }

    $sql = "
        SELECT 
            p.project_unique_id,
            CONCAT(s.firstname, ' ', s.lastname) AS project_owner, 
            p.company_name AS client_name,
            p.account_manager,
            p.product_type,
            p.start_date,
            p.end_date,
            p.source,
            p.status,
            p.current_stage,
            p.client_type,
            p.created_at,
            CASE
                WHEN p.start_date IS NULL 
                  OR p.start_date = '' 
                  OR p.start_date = 'No Data'
                  OR p.end_date IS NULL 
                  OR p.end_date = '' 
                  OR p.end_date = 'No Data'
                THEN 'NA'
                ELSE CONCAT(TIMESTAMPDIFF(DAY, p.start_date, p.end_date), ' days')
            END AS duration
        FROM projecttb AS p
        JOIN salesauth AS s
            ON s.user_id_current = p.user_id_cur
        WHERE s.company = :company
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company', $currentUserCompany, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch data
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure all statuses are included, even if their count is zero
    $defaultStatuses = ['Completed', 'Ongoing', 'Cancelled', 'Not Yet Started'];
    foreach ($rows as &$row) {
        if (empty($row['status']) || trim($row['status']) === '') {
            $row['status'] = 'Not Yet Started'; // Default status if empty
        }
    }

    Return JSON response
    echo json_encode([
        'status' => 'success',
        'data'   => $rows,
    ]);
    
} catch (PDOException $e) {
    // Handle any DB errors
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
