<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include("../auth/db.php"); 

try {
    // Fetch all project data (No filtering by user ID)
    $sql = "SELECT project_unique_id, company_name, account_manager, start_date, 
                   end_date, status, product_type, current_stage, client_type, source
            FROM projecttb";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all results as an array
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON output for Power BI
    echo json_encode($projects, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(["error" => "Query failed", "details" => $e->getMessage()]);
    exit;
}
?>
