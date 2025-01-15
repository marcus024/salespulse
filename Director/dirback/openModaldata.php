<?php
include('../../auth/db.php');

header('Content-Type: application/json');
// echo json_encode(["test" => "OK"]);


if (isset($_GET['project_id']) && !empty($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    try {
        $sql = "SELECT 
                    projecttb.project_unique_id AS project_id,
                    projecttb.company_name,
                    projecttb.current_stage,
                    stagefive.SPR_number,
                    COALESCE(stageone.start_date_stage_one, 'No Data') AS start_date_stage_one,
                    COALESCE(stageone.end_date_stage_one, 'No Data') AS end_date_stage_one,
                    COALESCE(stageone.status_stage_one, 'No Data') AS status_stage_one,
                    COALESCE(stageone.requirements, 'No Data') AS requirements,
                    COALESCE(stageone.solution, 'No Data') AS solution,
                    COALESCE(stageone.deal_size, 'No Data') AS deal_size,
                    COALESCE(stageone.remarks, 'No Data') AS remarks,
                    COALESCE(stageone.distributor, 'No Data') AS distributor,
                    COALESCE(stageone.product, 'No Data') AS product,
                    COALESCE(stagetwo.start_date_stage_two, 'No Data') AS start_date_stage_two,
                    COALESCE(stagetwo.end_date_stage_two, 'No Data') AS end_date_stage_two,
                    COALESCE(stagetwo.status_stage_two, 'No Data') AS status_stage_two,
                    COALESCE(stagethree.start_date_stage_three, 'No Data') AS start_date_stage_three,
                    COALESCE(stagethree.end_date_stage_three, 'No Data') AS end_date_stage_three,
                    COALESCE(stagethree.status_stage_three, 'No Data') AS status_stage_three,
                    COALESCE(stagefour.start_date_stage_four, 'No Data') AS start_date_stage_four,
                    COALESCE(stagefour.end_date_stage_four, 'No Data') AS end_date_stage_four,
                    COALESCE(stagefour.status_stage_four, 'No Data') AS status_stage_four,
                    COALESCE(stagefive.start_date_stage_five, 'No Data') AS start_date_stage_five,
                    COALESCE(stagefive.end_date_stage_five, 'No Data') AS end_date_stage_five,
                    COALESCE(stagefive.status_stage_five, 'No Data') AS status_stage_five
                FROM projecttb
                LEFT JOIN stageone ON projecttb.project_unique_id = stageone.project_unique_id
                LEFT JOIN stagetwo ON projecttb.project_unique_id = stagetwo.project_unique_id
                LEFT JOIN stagethree ON projecttb.project_unique_id = stagethree.project_unique_id
                LEFT JOIN stagefour ON projecttb.project_unique_id = stagefour.project_unique_id
                LEFT JOIN stagefive ON projecttb.project_unique_id = stagefive.project_unique_id
                WHERE projecttb.project_unique_id = :project_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $sprNum = $result['SPR_number'] ?? 'No SPR Number';

            echo json_encode([
                'status' => 'success',
                'company_name' => $result['company_name'] ?? '',
                'project_id'    => $result['project_id'] ?? '', 
                'current_stage' => $result['current_stage'] ?? '',
                'stages' => [
                    'stage_one' => [
                        'start_date' => $result['start_date_stage_one'],
                        'end_date' => $result['end_date_stage_one'],
                        'status' => $result['status_stage_one'],
                        'requirements' => $result['requirements'] ?? 'No Data',
                        'solution' => $result['solution'] ?? 'No Data',
                        'deal_size' => $result['deal_size'] ?? 'No Data',
                        'remarks' => $result['remarks'] ?? 'No Data',
                        'distributor' => $result['distributor'] ?? 'No Data',
                        'product' => $result['product'] ?? 'No Data'
                    ],
                    'stage_two' => [
                        'start_date' => $result['start_date_stage_two'],
                        'end_date' => $result['end_date_stage_two'],
                        'status' => $result['status_stage_two']
                    ],
                    'stage_three' => [
                        'start_date' => $result['start_date_stage_three'],
                        'end_date' => $result['end_date_stage_three'],
                        'status' => $result['status_stage_three']
                    ],
                    'stage_four' => [
                        'start_date' => $result['start_date_stage_four'],
                        'end_date' => $result['end_date_stage_four'],
                        'status' => $result['status_stage_four']
                    ],
                    'stage_five' => [
                        'start_date' => $result['start_date_stage_five'],
                        'end_date' => $result['end_date_stage_five'],
                        'status' => $result['status_stage_five'],
                        // 'sprNum' => $sprNum
                    ]
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Project not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Project ID is required.']);
}
