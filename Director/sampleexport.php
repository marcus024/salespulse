<?php
header('Content-Type: application/json');

include('../auth/db.php';)

// Fetch project data
$sql = "SELECT project_unique_id,company_name, company_name, account_manager,status,start_date, end_date, created_at, product_type, current_stage, client_type,source FROM projects";
                                                          
$result = $conn->query($sql);

$projects = [];

while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

// Return JSON data
echo json_encode($projects);

$conn->close();
?>
