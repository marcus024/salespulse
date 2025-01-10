<?php
 
include '../../auth/db.php';  

 
$current_project_id = htmlspecialchars($_GET['project_id'] ?? '');  
$stage = intval($_GET['stage'] ?? 0);  

$response = [];

 
if (!$current_project_id) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Project ID is required']);
    exit;
}

 
function fetchStageDetails($query, $conn, $project_id) {
    try {
        $stmt = $conn->prepare($query);  
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);  
        $stmt->execute();  
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  
    } catch (PDOException $e) {
         
        return ['error' => $e->getMessage()];
    }
}

 
function fetchProjectDetails($conn, $project_id) {
    try {
         
        $query = "SELECT status, account_manager, company_name, start_date, end_date 
                  FROM projecttb
                  WHERE project_unique_id = :project_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  
    } catch (PDOException $e) {
         
        return ['error' => $e->getMessage()];
    }
}

 
$projectDetails = fetchProjectDetails($conn, $current_project_id);
if ($projectDetails) {
    $response['project_details'] = $projectDetails;  
} else {
     
    $response['project_details'] = ['error' => 'No project details found'];
}

 
try {
    switch ($stage) {
       case 1:
     
    $stageOneDetails = fetchStageDetails("
        SELECT start_date_stage_one, end_date_stage_one, technology, solution, deal_size, distributor, stage_one_remarks, product, status_stage_one
        FROM stageone WHERE project_unique_id = :project_id", $conn, $current_project_id);

     
    $requirementOneDetails = fetchStageDetails("
        SELECT requirement_one 
        FROM requirementone_tb WHERE project_unique_id = :project_id", $conn, $current_project_id);

     
    if (!empty($stageOneDetails)) {
        $stageOneData = $stageOneDetails[0];  
        $response['stage_one'] = [
            'status' => 'success',
            'start_date' => $stageOneData['start_date_stage_one'] ?? null,
            'end_date' => $stageOneData['end_date_stage_one'] ?? null,
            'technology' => $stageOneData['technology'] ?? 'N/A',
            'solution' => $stageOneData['solution'] ?? 'No Solution Available',
            'deal_size' => $stageOneData['deal_size'] ?? 0,
            'distributor' => $stageOneData['distributor'] ?? 'N/A',
            'remarks' => $stageOneData['stage_one_remarks'] ?? 'No Remarks Available',
            'product' => $stageOneData['product'] ?? 'N/A',
            'status_stage' => $stageOneData['status_stage_one'] ?? 'N/A',
        ];
    } else {
        $response['stage_one'] = ['status' => 'error', 'message' => 'No details available for Stage One.'];
    }

    if (!empty($requirementOneDetails)) {
        $response['requirement_one'] = array_map(function ($req) {
            return [
                'requirement' => $req['requirement_one'] ?? 'N/A',
            ];
        }, $requirementOneDetails);
    } else {
        $response['requirement_one'] = ['status' => 'error', 'message' => 'No requirements available for Stage One.'];
    }
    break;

        case 2:
            $response['stage_two'] = fetchStageDetails("
                SELECT start_date_stage_two, end_date_stage_two, technology, solution, deal_size, product, stage_two_remarks, status_stage_two
                FROM stagetwo WHERE project_unique_id = :project_id", $conn, $current_project_id);
            $response['requirements_two'] = fetchStageDetails("
                SELECT requirement_two, requirement_date, requirement_remarks FROM requirement_twotb WHERE project_unique_id = :project_id", $conn, $current_project_id);
            $response['engagements_two'] = fetchStageDetails("
                SELECT engagement_type, engagement_date, engagement_remarks FROM engagement_twotb WHERE project_unique_id = :project_id", $conn, $current_project_id);
            break;
         
        default:
            throw new Exception("Invalid stage number.");
    }

    // Return response
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
