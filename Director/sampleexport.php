<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
session_start();
include("../auth/db.php"); 

// Hardcoded or passed user ID (Power BI doesn't support sessions)
$user_id =$_SESSION['user_id_c'] ?? null;

if (!$user_id) {
    echo json_encode(["error" => "User ID is required"]);
    exit;
}

try {
    // Prepare SQL query
    $sql = "SELECT project_unique_id, company_name, account_manager, start_date, 
                   end_date, status, product_type, current_stage, client_type, source
            FROM projecttb
            WHERE user_id_cur = :user_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
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
