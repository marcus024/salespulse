<?php

// Function to fetch Stage One Data
function fetchStageOneData(PDO $conn, $projectUniqueId) {
    $sql = "
        SELECT DISTINCT
            s.solution,
            s.technology,
            s.deal_size,
            s.stage_one_remarks,
            s.status_stage_one,
            s.start_date_stage_one,
            s.end_date_stage_one,
            r.requirement_one,
            r.product_one,
            r.distributor_one
        FROM stageone AS s
        LEFT JOIN requirementone_tb AS r
            ON s.project_unique_id = r.project_unique_id
        WHERE s.project_unique_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$projectUniqueId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) === 0) {
        return null;
    }

    $stageOneData = [
        'solution'             => $rows[0]['solution'],
        'technology'           => $rows[0]['technology'],
        'deal_size'            => $rows[0]['deal_size'],
        'stage_one_remarks'    => $rows[0]['stage_one_remarks'],
        'status_stage_one'     => $rows[0]['status_stage_one'],
        'start_date_stage_one' => $rows[0]['start_date_stage_one'],
        'end_date_stage_one'   => $rows[0]['end_date_stage_one'],
        'requirements'         => [],
        'products'             => [],
        'distributors'         => []
    ];

     foreach ($rows as $row) {
        if (!empty($row['requirement_one'])) {
            $stageOneData['requirements'][] = $row['requirement_one'];
        }

        if (!empty($row['product_one'])) {
            $stageOneData['products'][] = $row['product_one'];
        }

        if (!empty($row['distributor_one'])) {
            $stageOneData['distributors'][] = $row['distributor_one'];
        }
    }

    return $stageOneData;
}

// Retrieve the Project Unique ID from GET parameters
$projectUniqueId = $_GET['project_id'] ?? null;

// Initialize variables to hold data and error messages
$stageOneData = null;
$error = null;

// Only attempt to fetch data if project_unique_id is provided and database connection is successful
if ($projectUniqueId && isset($conn)) {
    try {
        $stageOneData = fetchStageOneData($conn, $projectUniqueId);

        if (!$stageOneData) {
            $error = "No Stage 1 data found for Project ID: " . htmlspecialchars($projectUniqueId);
        } 
    } catch (Exception $e) {
        // Log the error (optional)
        error_log("Error fetching Stage 1 data: " . $e->getMessage());

        // Set a user-friendly error message
        $error = "An error occurred while fetching Stage 1 data. Please try again later.";
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

if (!empty($error)) {
    echo '<div class="alert alert-warning" role="alert">';
    echo htmlspecialchars($error);
    echo '</div>';
}
?>
