<?php

function fetchStageThreeData(PDO $conn, string $projectUniqueId)
{
    
    $stageThreeQuery = "SELECT *
                       FROM stagethree
                       WHERE project_unique_id = ?
                       LIMIT 1";
    $stmt = $conn->prepare($stageThreeQuery);
    $stmt->execute([$projectUniqueId]);
    $stageThreeRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$stageThreeRow) {
        return null;
    }

    
    $requirementsQuery = "SELECT *
                          FROM requirement_threetb
                          WHERE project_unique_id = ?";
    $stmt = $conn->prepare($requirementsQuery);
    $stmt->execute([$projectUniqueId]);
    $requirements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $engagementsQuery = "SELECT *
                         FROM enagement_threetb
                         WHERE project_unique_id = ?";
    $stmt = $conn->prepare($engagementsQuery);
    $stmt->execute([$projectUniqueId]);
    $engagements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    return [
        'stage_three'  => $stageThreeRow,   
        'requirements' => $requirements,    
        'engagements'  => $engagements      
    ];
}


$projectUniqueId = $_GET['project_id'] ?? null;


$data = null;
$error = null;


if ($projectUniqueId && isset($conn)) {
    try {
        $data = fetchStageThreeData($conn, $projectUniqueId);

        if (!$data) {
            $error = "No Stage 3 data found for Project ID: " . htmlspecialchars($projectUniqueId);
        }
    } catch (Exception $e) {
        // Log the error for server-side debugging
        error_log("Error fetching Stage Three data: " . $e->getMessage());

        // Set a user-friendly error message
        $error = "An error occurred while fetching Stage Three data. Please try again later.";
    }
} elseif (!$projectUniqueId) {
    $error = "No Project ID provided.";
} else {
    // If $conn is not set due to a connection error
    if (isset($dbError)) {
        $error = $dbError;
    } else {
        $error = "An unexpected error occurred.";
    }
}

// Display Error Message if Any
if (!empty($error)) {
    echo '<div class="alert alert-warning" style="display:none;" role="alert">' . htmlspecialchars($error) . '</div>';
}

?>