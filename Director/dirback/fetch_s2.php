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
        // No stagetwo row found for this project
        return null;
    }

    // 2) Fetch all requirements for Stage 2
    $requirementsQuery = "SELECT *
                          FROM requirement_twotb
                          WHERE project_unique_id = ?";
    $stmt = $conn->prepare($requirementsQuery);
    $stmt->execute([$projectUniqueId]);
    $requirements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Fetch all engagements for Stage 2
    $engagementsQuery = "SELECT *
                         FROM engagement_twotb
                         WHERE project_unique_id = ?";
    $stmt = $conn->prepare($engagementsQuery);
    $stmt->execute([$projectUniqueId]);
    $engagements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Combine everything into one return array
    return [
        'stage_two'    => $stageTwoRow,   // Single row from stagetwo
        'requirements' => $requirements,  // Array of rows from requirement_twotb
        'engagements'  => $engagements    // Array of rows from engagement_twotb
    ];
}

$projectUniqueId = $_GET['project_id'] ?? null;

// Initialize variables to hold data and error messages
$data = null;
$error = null;

// Only attempt to fetch data if project_unique_id is provided and database connection is successful
if ($projectUniqueId && isset($conn)) {
    try {
        $data = fetchStageTwoData($conn, $projectUniqueId);

        if (!$data) {
            $error = "No Stage 2 data found for Project ID: " . htmlspecialchars($projectUniqueId);
        }
        //  echo '<pre>';
        //     print_r($data);
        //     echo '</pre>';
    } catch (Exception $e) {
        // Log the error (optional)
        error_log("Error fetching Stage 2 data: " . $e->getMessage());

        // Set a user-friendly error message
        $error = "An error occurred while fetching Stage 2 data. Please try again later.";
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
    echo '<div class="alert alert-warning" role="alert">';
    echo htmlspecialchars($error);
    echo '</div>';
}
