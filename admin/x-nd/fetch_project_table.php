<?php
session_start();
header('Content-Type: application/json');

// Include your database connection
include('../../auth/db.php');

// 1. Retrieve the current user's company
$currentUserCompany = $_SESSION['company'] ?? '';

try {
 
    $sql = "SELECT 
    p.project_unique_id,
    CONCAT(s.firstname, ' ', s.lastname) AS project_owner, 
    p.company_name     AS client_name,
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

    // 3. Fetch data
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Return JSON
    echo json_encode([
        'status' => 'success',
        'data'   => $rows
    ]);
    
} catch (PDOException $e) {
    // Handle any DB errors
    echo json_encode([
        'status'  => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
