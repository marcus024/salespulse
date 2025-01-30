<?php
header('Content-Type: application/json');

include('../auth/db.php');// Fixed syntax error


// Fetch project data
$sql = "SELECT project_unique_id, company_name, account_manager, status, start_date, end_date, created_at, product_type, current_stage, client_type, source FROM projecttb";

$result = $conn->query($sql);

$projects = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    $result->free();
} else {
    die(json_encode(["error" => "Query failed", "details" => $conn->error]));
}

// Return JSON data
echo json_encode($projects);

$conn->close();
?>
