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
                    COALESCE(stageone.solution, 'No Data') AS solution,
                    COALESCE(stageone.deal_size, 'No Data') AS dealsize,
                    COALESCE(stageone.stage_one_remarks, 'No Data') AS stage_one_remarks,
                    COALESCE(stageone.distributor, 'No Data') AS distributor,
                    COALESCE(stageone.product, 'No Data') AS product,
                    COALESCE(stageone.technology, 'No Data') AS technology,
                    GROUP_CONCAT(DISTINCT CONCAT(requirementone_tb.requirement_id_one, ':', requirementone_tb.requirement_one) SEPARATOR ',') AS requirements,
                    COALESCE(stagetwo.start_date_stage_two, 'No Data') AS start_date_stage_two,
                    COALESCE(stagetwo.end_date_stage_two, 'No Data') AS end_date_stage_two,
                    COALESCE(stagetwo.status_stage_two, 'No Data') AS status_stage_two,
                    COALESCE(stagetwo.stage_two_remarks, 'No Data') AS stage_two_remarks,
                    COALESCE(stagetwo.technology, 'No Data') AS technology_stage_two,
                    COALESCE(stagetwo.deal_size, 'No Data') AS deal_size_stage_two,
                    COALESCE(stagetwo.product, 'No Data') AS product_stage_two,
                    COALESCE(stagetwo.solution, 'No Data') AS solution_stage_two,
                    GROUP_CONCAT(DISTINCT CONCAT(engagement_twotb.engagement_id_two, ':', engagement_twotb.engagement_type, ':', engagement_twotb.engagement_date, ':', engagement_twotb.engagement_remarks) ORDER BY engagement_twotb.engagement_date) AS engagement_2,
                    GROUP_CONCAT(DISTINCT CONCAT(requirement_twotb.requirement_id_two, ':', requirement_twotb.requirement_two, ':', requirement_twotb.requirement_date, ':', requirement_twotb.requirement_remarks) ORDER BY requirement_twotb.requirement_date) AS requirement_2,
                    COALESCE(stagethree.start_date_stage_three, 'No Data') AS start_date_stage_three,
                    COALESCE(stagethree.end_date_stage_three, 'No Data') AS end_date_stage_three,
                    COALESCE(stagethree.status_stage_three, 'No Data') AS status_stage_three,
                    COALESCE(stagethree.stage_three_remarks, 'No Data') AS remarks_3,
                    COALESCE(stagethree.product, 'No Data') AS product_3,
                    COALESCE(stagethree.technology, 'No Data') AS technology_3,
                    COALESCE(stagethree.deal_size, 'No Data') AS deal_3,
                    COALESCE(stagethree.solution, 'No Data') AS solution_3,
                    COALESCE(stagefour.start_date_stage_four, 'No Data') AS start_date_stage_four,
                    COALESCE(stagefour.end_date_stage_four, 'No Data') AS end_date_stage_four,
                    COALESCE(stagefour.status_stage_four, 'No Data') AS status_stage_four,
                    COALESCE(stagefour.stage_four_remarks, 'No Data') AS remarks_4,
                    COALESCE(stagefour.technology, 'No Data') AS technology_4,
                    COALESCE(stagefour.solution, 'No Data') AS solution_4,
                    COALESCE(stagefour.product, 'No Data') AS product_4,
                    COALESCE(stagefour.deal_size, 'No Data') AS deal_4,
                    COALESCE(stagefive.start_date_stage_five, 'No Data') AS start_date_stage_five,
                    COALESCE(stagefive.end_date_stage_five, 'No Data') AS end_date_stage_five,
                    COALESCE(stagefive.status_stage_five, 'No Data') AS status_stage_five,
                    COALESCE(stagefive.remarks_stage_five, 'No Data') AS remarks_5,
                    COALESCE(stagefive.solution, 'No Data') AS solution_5,
                    COALESCE(stagefive.technology, 'No Data') AS technology_5,
                    COALESCE(stagefive.deal_size, 'No Data') AS deal_5,
                    COALESCE(stagefive.product, 'No Data') AS product_5,
                    COALESCE(stagefive.pricing, 'No Data') AS pricing,
                    COALESCE(stagefive.contract_duration, 'No Data') AS contract_duration,
                    COALESCE(stagefive.SPR_number, 'No Data') AS spr_number,
                    COALESCE(stagefive.billing_type, 'No Data') AS billing_type
                FROM projecttb
                LEFT JOIN requirementone_tb ON projecttb.project_unique_id = requirementone_tb.project_unique_id
                LEFT JOIN engagement_twotb ON projecttb.project_unique_id = engagement_twotb.project_unique_id
                LEFT JOIN requirement_twotb ON projecttb.project_unique_id = requirement_twotb.project_unique_id
                LEFT JOIN stageone ON projecttb.project_unique_id = stageone.project_unique_id
                LEFT JOIN stagetwo ON projecttb.project_unique_id = stagetwo.project_unique_id
                LEFT JOIN stagethree ON projecttb.project_unique_id = stagethree.project_unique_id
                LEFT JOIN stagefour ON projecttb.project_unique_id = stagefour.project_unique_id
                LEFT JOIN stagefive ON projecttb.project_unique_id = stagefive.project_unique_id
                WHERE projecttb.project_unique_id = :project_id
                GROUP BY projecttb.project_unique_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

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
                        'solution' => $result['solution'],
                        'deal_size' => $result['dealsize'] ,
                        'remarks' => $result['stage_one_remarks'],
                        'distributor' => $result['distributor'],
                        'product' => $result['product'],
                        'technology' => $result['technology'],
                        'requirements' => isset($result['requirements'])
                        ? array_map(function ($requirement) {
                            $parts = explode(':', $requirement); // Split "id:requirement" format
                            return [
                                'requirement_id_one' => $parts[0] ?? null,  // Extract ID
                                'requirement_one' => $parts[1] // Extract text
                            ];
                        }, array_unique(explode(',', $result['requirements']))) // Remove duplicates
                        : []
                    ],
                    'stage_two' => [
                    'start_date' => $result['start_date_stage_two'],
                    'end_date' => $result['end_date_stage_two'],
                    'status' => $result['status_stage_two'],
                    'remarks_two' => $result['stage_two_remarks'],
                    'technology_two' => $result['technology_stage_two'],
                    'deal_size_two' => $result['deal_size_stage_two'],
                    'product_two' => $result['product_stage_two'],
                    'solution_two' => $result['solution_stage_two'],
                    
                    // Corrected engagement_two
                    'engagement_two' => isset($result['engagement_2']) 
                    ? array_map(function ($engagement) {
                        $parts = explode(':', $engagement); 
                        return [
                            'engagement_id_two' => $parts[0] ?? null, 
                            'engagement_type' => $parts[1] ?? null,
                            'engagement_date' => $parts[2] ?? null,  
                            'engagement_remarks' => $parts[3] ?? null
                        ];
                    }, array_values(array_unique(
                        array_map(function ($engagement) {
                            $parts = explode(':', $engagement);
                            // Remove duplicates based on all fields except id
                            return implode(':', array_slice($parts, 1)); // Join all parts except the id
                        }, explode(',', $result['engagement_2']))
                    )))
                    : [],
                    // Corrected requirement_two
                    
'requirement_two' => isset($result['requirement_2']) 
    ? array_values(array_map(function ($requirement) {
        $parts = explode(':', $requirement); 
        return [
            'requirement_id_two' => $parts[0] ?? '',  // Keep the ID intact
            'requirement_two' => isset($parts[1]) ? $parts[1] : '', 
            'requirement_date' => isset($parts[2]) ? $parts[2] : '',  
            'requirement_remarks' => isset($parts[3]) ? $parts[3] : ''
        ];
    }, array_values(array_unique(
        array_map(function ($requirement) {
            $parts = explode(':', $requirement);
            // Create a unique key based on all fields except the ID
            return implode(':', array_slice($parts, 1)); // Concatenate all parts except the id
        }, explode(',', $result['requirement_2']))
    ))))
    : [],



                ],
                    'stage_three' => [
                        'start_date' => $result['start_date_stage_three'],
                        'end_date' => $result['end_date_stage_three'],
                        'status' => $result['status_stage_three'],
                        'remarks_three' => $result['remarks_3'],
                        'product_three' => $result['product_3'],
                        'technology_three' => $result['technology_3'],
                        'solution_three' => $result['solution_3'],
                        'deal_size_three' => $result['deal_3']
                    ],
                    'stage_four' => [
                        'start_date' => $result['start_date_stage_four'],
                        'end_date' => $result['end_date_stage_four'],
                        'status' => $result['status_stage_four'],
                        'remarks_four' => $result['remarks_4'],
                        'product_four' => $result['product_4'],
                        'technology_four' => $result['technology_4'],
                        'solution_four' => $result['solution_4'],
                        'deal_size_four' => $result['deal_4']
                    ],
                    'stage_five' => [
                        'start_date' => $result['start_date_stage_five'],
                        'end_date' => $result['end_date_stage_five'],
                        'status' => $result['status_stage_five'],
                        'remarks_five' => $result['remarks_5'],
                        'product_five' => $result['product_5'],
                        'solution_five' => $result['solution_5'],
                        'technology_five' => $result['technology_5'],
                        'deal_size_five' => $result['deal_5'],
                        'billing_type' => $result['billing_type'],
                        'contract_duration' => $result['contract_duration'],
                        'pricing' => $result['pricing'],
                        'spr' => $result['spr_number']
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
