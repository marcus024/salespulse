<?php
// Assuming you have a PDO database connection established
$current_project_id = htmlspecialchars($project['project_unique_id']); // Get the current project ID

// Query to select the status from projecttb
$query_status = "SELECT status FROM projecttb WHERE project_unique_id = :project_id";
$stmt_status = $conn->prepare($query_status);
$stmt_status->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_status->execute();
$status_data = $stmt_status->fetch(PDO::FETCH_ASSOC);

// Check if a status is returned, otherwise set to default value
if ($status_data) {
    $status = $status_data['status'];
} else {
    $status = 'No Status Available'; // Default value if no status is found
}

// Prepare queries for stages 1 to 5
$query_stage_one = "SELECT start_date_stage_one, end_date_stage_one, DATEDIFF(end_date_stage_one, start_date_stage_one) AS duration FROM stageone WHERE project_unique_id = :project_id ";
$query_stage_two = "SELECT start_date_stage_two, end_date_stage_two, DATEDIFF(end_date_stage_two, start_date_stage_two) AS duration FROM stagetwo WHERE project_unique_id = :project_id ";
$query_stage_three = "SELECT start_date_stage_three, end_date_stage_three, DATEDIFF(end_date_stage_three, start_date_stage_three) AS duration FROM stagethree WHERE project_unique_id = :project_id ";
$query_stage_four = "SELECT start_date_stage_four, end_date_stage_four, DATEDIFF(end_date_stage_four, start_date_stage_four) AS duration FROM stagefour WHERE project_unique_id = :project_id ";
$query_stage_five = "SELECT status_stage_five,start_date_stage_five, end_date_stage_five, DATEDIFF(end_date_stage_five, start_date_stage_five) AS duration FROM stagefive WHERE project_unique_id = :project_id ";

// Execute queries for each stage using PDO and check for data existence

// Stage One
$stmt_stage_one = $conn->prepare($query_stage_one);
$stmt_stage_one->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_stage_one->execute();
$stage_one_data = $stmt_stage_one->fetch(PDO::FETCH_ASSOC);

if ($stage_one_data) {
    $start_date_stage_one = $stage_one_data['start_date_stage_one'];
    $end_date_stage_one = $stage_one_data['end_date_stage_one'];
    $duration_stage_one = $stage_one_data['duration'];
} else {
    $start_date_stage_one = 'Not Yet Started';
    $end_date_stage_one = 'Not Yet Ended';
    $duration_stage_one = 'N/A';
}

// Stage Two
$stmt_stage_two = $conn->prepare($query_stage_two);
$stmt_stage_two->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_stage_two->execute();
$stage_two_data = $stmt_stage_two->fetch(PDO::FETCH_ASSOC);

if ($stage_two_data) {
    $start_date_stage_two = $stage_two_data['start_date_stage_two'];
    $end_date_stage_two = $stage_two_data['end_date_stage_two'];
    $duration_stage_two = $stage_two_data['duration'];
} else {
    $start_date_stage_two = 'Not Yet Started';
    $end_date_stage_two = 'Not Yet Ended';
    $duration_stage_two = 'N/A';
}

// Stage Three
$stmt_stage_three = $conn->prepare($query_stage_three);
$stmt_stage_three->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_stage_three->execute();
$stage_three_data = $stmt_stage_three->fetch(PDO::FETCH_ASSOC);

if ($stage_three_data) {
    $start_date_stage_three = $stage_three_data['start_date_stage_three'];
    $end_date_stage_three = $stage_three_data['end_date_stage_three'];
    $duration_stage_three = $stage_three_data['duration'];
} else {
    $start_date_stage_three = 'Not Yet Started';
    $end_date_stage_three = 'Not Yet Ended';
    $duration_stage_three = 'N/A';
}

// Stage Four
$stmt_stage_four = $conn->prepare($query_stage_four);
$stmt_stage_four->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_stage_four->execute();
$stage_four_data = $stmt_stage_four->fetch(PDO::FETCH_ASSOC);

if ($stage_four_data) {
    $start_date_stage_four = $stage_four_data['start_date_stage_four'];
    $end_date_stage_four = $stage_four_data['end_date_stage_four'];
    $duration_stage_four = $stage_four_data['duration'];
} else {
    $start_date_stage_four = 'Not Yet Started';
    $end_date_stage_four = 'Not Yet Ended';
    $duration_stage_four = 'N/A';
}

// Stage Five
$stmt_stage_five = $conn->prepare($query_stage_five);
$stmt_stage_five->bindParam(':project_id', $current_project_id, PDO::PARAM_STR);
$stmt_stage_five->execute();
$stage_five_data = $stmt_stage_five->fetch(PDO::FETCH_ASSOC);

if ($stage_five_data) {
    $start_date_stage_five = $stage_five_data['start_date_stage_five'];
    $end_date_stage_five = $stage_five_data['end_date_stage_five'];
    $duration_stage_five = $stage_five_data['duration'];
    $status_stage_five = $stage_five_data['status_stage_five'];
} else {
    $start_date_stage_five = 'Not Yet Started';
    $end_date_stage_five = 'Not Yet Ended';
    $duration_stage_five = 'N/A';
    $status_stage_five = 'Not Yet Started';
}
?>
