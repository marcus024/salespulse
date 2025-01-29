<?php

function fetchStageTwoData(PDO $conn, string $projectUniqueId)
{
    // 1) Fetch the single row from stagetwo
    $stageTwoQuery = "SELECT *
                      FROM stagetwo
                      WHERE project_unique_id = ?
                      LIMIT 1";
    $stmt = $conn->prepare($stageTwoQuery);
    $stmt->execute([$projectUniqueId]);
    $stageTwoRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stageTwoRow) {
        return null; // No stagetwo row found
    }

    // 2) Fetch all requirements for Stage 2
    $requirementsQuery = "SELECT requirement_id_two, requirement_two, requirement_date, product_two, distributor_two, requirement_remarks 
                          FROM requirement_twotb
                          WHERE project_unique_id = ?";
    $stmt = $conn->prepare($requirementsQuery);
    $stmt->execute([$projectUniqueId]);
    $requirements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Fetch all engagements for Stage 2
    $engagementsQuery = "SELECT engagement_id_two, engagement_type, engagement_date, engagement_remarks 
                         FROM engagement_twotb
                         WHERE project_unique_id = ?";
    $stmt = $conn->prepare($engagementsQuery);
    $stmt->execute([$projectUniqueId]);
    $engagements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Combine everything into one return array
    return [
        'stage_two'    => $stageTwoRow,
        'requirements' => $requirements,
        'engagements'  => $engagements
    ];
}

// Fetch project data
$projectUniqueId = $_GET['project_id'] ?? null;
$data = null;
$error = null;

if ($projectUniqueId && isset($conn)) {
    try {
        $data = fetchStageTwoData($conn, $projectUniqueId);
        if (!$data) {
            $error = "No Stage 2 data found for Project ID: " . htmlspecialchars($projectUniqueId);
        }
    } catch (Exception $e) {
        error_log("Error fetching Stage 2 data: " . $e->getMessage());
        $error = "An error occurred while fetching Stage 2 data. Please try again later.";
    }
} elseif (!$projectUniqueId) {
    $error = "No Project ID provided.";
} else {
    $error = isset($dbError) ? $dbError : "An unexpected error occurred.";
}

// Display Error Message if Any
if (!empty($error)) {
    echo '<div class="alert alert-warning" style="display:none;" role="alert">' . htmlspecialchars($error) . '</div>';
}

?>
