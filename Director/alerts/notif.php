<?php
include('../../auth/db.php');
session_start();

$response = [
    'projects' => [],
    'stages' => [],
    'user_id_cur' => $_SESSION['user_id_c'] ?? null,
];

// Fetch the current user's ID from the session
$user_id = $_SESSION['user_id_c'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in.']);
    exit;
}

try {
    // Fetch projects associated with the current user
    $sql = "
        SELECT 
            p.project_unique_id, 
            p.company_name, 
            p.account_manager, 
            p.status AS pstatus,
            p.start_date, 
            p.end_date, 
            p.created_at
        FROM projecttb p
        INNER JOIN salesauth s 
            ON p.user_id_cur = s.user_id_current
        WHERE s.user_id_current = :current_user AND 
              p.status NOT IN ('Cancelled', 'Completed') AND
              DATEDIFF(CURDATE(), GREATEST(p.created_at, p.start_date)) > 3
        ORDER BY p.created_at DESC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_user', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all projects
    $response['projects'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch all stages for the current user's projects
    $stageSql = "
        SELECT 
            stages.project_unique_id, 
            stages.stage_name, 
            stages.start_date
        FROM (
            SELECT 
                project_unique_id, 
                'Stage 1' AS stage_name, 
                start_date_stage_one AS start_date 
            FROM stageone
            UNION ALL
            SELECT 
                project_unique_id, 
                'Stage 2' AS stage_name, 
                start_date_stage_two AS start_date 
            FROM stagetwo
            UNION ALL
            SELECT 
                project_unique_id, 
                'Stage 3' AS stage_name, 
                start_date_stage_three AS start_date 
            FROM stagethree
            UNION ALL
            SELECT 
                project_unique_id, 
                'Stage 4' AS stage_name, 
                start_date_stage_four AS start_date 
            FROM stagefour
            UNION ALL
            SELECT 
                project_unique_id, 
                'Stage 5' AS stage_name, 
                start_date_stage_five AS start_date 
            FROM stagefive
        ) AS stages
        WHERE stages.project_unique_id IN (
            SELECT project_unique_id 
            FROM projecttb 
            WHERE user_id_cur = :current_user
        )
    ";
    $stageStmt = $conn->prepare($stageSql);
    $stageStmt->bindParam(':current_user', $user_id, PDO::PARAM_STR);
    $stageStmt->execute();

    // Fetch all stages
    $response['stages'] = $stageStmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
