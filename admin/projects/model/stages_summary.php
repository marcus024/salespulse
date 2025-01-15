<?php
 
$current_project_id = htmlspecialchars($project['project_unique_id']);  

 
$query_status = "SELECT status FROM projecttb WHERE project_unique_id = :project_id";
$stmt_status = $conn->prepare($query_status);
$stmt_status->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_status->execute();
$status_data = $stmt_status->fetch(PDO::FETCH_ASSOC);

 
if ($status_data) {
    $status = $status_data['status'];
} else {
    $status = 'No Status Available';  
}

 
function fetchStageDetails($query, $conn, $current_project_id) {
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

 
$query_stage_one = "
    SELECT start_date_stage_one, end_date_stage_one, DATEDIFF(end_date_stage_one, start_date_stage_one) AS duration, 
    technology, solution, deal_size, distributor, stage_one_remarks, product, status_stage_one
    FROM stageone WHERE project_unique_id = :project_id
";
$stage_one_data = fetchStageDetails($query_stage_one, $conn, $current_project_id);

$query_requirement_one = "SELECT requirement_one FROM requirementone_tb WHERE project_unique_id = :project_id";
$requirements_one = fetchStageDetails($query_requirement_one, $conn, $current_project_id);

 
$query_stage_two = "
    SELECT start_date_stage_two, end_date_stage_two, DATEDIFF(end_date_stage_two, start_date_stage_two) AS duration,
    technology, deal_size, product, solution, stage_two_remarks, status_stage_two
    FROM stagetwo WHERE project_unique_id = :project_id
";
$stage_two_data = fetchStageDetails($query_stage_two, $conn, $current_project_id);

$query_requirement_two = "SELECT requirement_two, requirement_date, requirement_remarks FROM requirement_twotb WHERE project_unique_id = :project_id";
$requirements_two = fetchStageDetails($query_requirement_two, $conn, $current_project_id);

$query_engagement_two = "SELECT engagement_type, engagement_date, engagement_remarks FROM engagement_twotb WHERE project_unique_id = :project_id";
$engagements_two = fetchStageDetails($query_engagement_two, $conn, $current_project_id);

 
$query_stage_three = "
    SELECT start_date_stage_three, end_date_stage_three, DATEDIFF(end_date_stage_three, start_date_stage_three) AS duration,
    technology, deal_size, product, solution, stage_three_remarks, status_stage_three
    FROM stagethree WHERE project_unique_id = :project_id
";
$stage_three_data = fetchStageDetails($query_stage_three, $conn, $current_project_id);

$query_requirement_three = "SELECT requirement_three, quantity, bill_of_materials, requirement_remarks_three, pricing FROM requirement_threetb WHERE project_unique_id = :project_id";
$requirements_three = fetchStageDetails($query_requirement_three, $conn, $current_project_id);

$query_engagement_three = "SELECT engagement_three, engagement_date, engagement_remarks_three FROM enagement_threetb WHERE project_unique_id = :project_id";
$engagements_three = fetchStageDetails($query_engagement_three, $conn, $current_project_id);

 
$query_stage_four = "
    SELECT start_date_stage_four, end_date_stage_four, DATEDIFF(end_date_stage_four, start_date_stage_four) AS duration,
    technology, deal_size, product, solution, stage_four_remarks, status_stage_four
    FROM stagefour WHERE project_unique_id = :project_id
";
$stage_four_data = fetchStageDetails($query_stage_four, $conn, $current_project_id);

$query_requirement_four = "SELECT requirement_four, quantity, bill_of_materials, pricing, date_required FROM requirement_fourtb WHERE project_unique_id = :project_id";
$requirements_four = fetchStageDetails($query_requirement_four, $conn, $current_project_id);

 
$query_stage_five = "
    SELECT start_date_stage_five, end_date_stage_five, DATEDIFF(end_date_stage_five, start_date_stage_five) AS duration,
    SPR_number, contract_duration, billing_type, pricing, solution, technology, deal_size, product, remarks_stage_five, status_stage_five
    FROM stagefive WHERE project_unique_id = :project_id
";
$stage_five_data = fetchStageDetails($query_stage_five, $conn, $current_project_id);

$query_requirement_five = "SELECT req_five, quantity, bills_materials_req, remarks_req FROM requirementfive_tb WHERE project_unique_id = :project_id";
$requirements_five = fetchStageDetails($query_requirement_five, $conn, $current_project_id);

$query_upsell = "SELECT upsell, bills_materials_upsell, quantity_upsell, remarks_upsell, amount_upsell FROM upsell_tb WHERE project_unique_id = :project_id";
$upsell_data = fetchStageDetails($query_upsell, $conn, $current_project_id);

 
$project_data = [
    'status' => $status,
    'stage_one' => $stage_one_data,
    'requirements_one' => $requirements_one,
    'stage_two' => $stage_two_data,
    'requirements_two' => $requirements_two,
    'engagements_two' => $engagements_two,
    'stage_three' => $stage_three_data,
    'requirements_three' => $requirements_three,
    'engagements_three' => $engagements_three,
    'stage_four' => $stage_four_data,
    'requirements_four' => $requirements_four,
    'stage_five' => $stage_five_data,
    'requirements_five' => $requirements_five,
    'upsell' => $upsell_data,
];

 
// echo "<pre>";
// print_r($project_data);
// echo "</pre>";
?>
