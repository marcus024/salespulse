<?php


function fetchStageFiveData(PDO $conn, string $projectUniqueId)
{
    // 1) Fetch the single row from stagefive
    $stageFiveQuery = "SELECT *
                       FROM stagefive
                       WHERE project_unique_id = ?
                       LIMIT 1";
    $stmt = $conn->prepare($stageFiveQuery);
    $stmt->execute([$projectUniqueId]);
    $stageFiveRow = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no stagefive row found, return null
    if (!$stageFiveRow) {
        return null;
    }

    // 2) Fetch all requirements for Stage 5 (requirementfive_tb)
    $requirementsQuery = "SELECT *
                          FROM requirementfive_tb
                          WHERE project_unique_id = ?";
    $stmt = $conn->prepare($requirementsQuery);
    $stmt->execute([$projectUniqueId]);
    $requirements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3) Fetch all upsells for Stage 5 (upsell_tb)
    $upsellQuery = "SELECT *
                    FROM upsell_tb
                    WHERE project_unique_id = ?";
    $stmt = $conn->prepare($upsellQuery);
    $stmt->execute([$projectUniqueId]);
    $upsells = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4) Combine everything into one return array
    return [
        'stage_five'   => $stageFiveRow,    // single row from stagefive
        'requirements' => $requirements,    // array of rows from requirementfive_tb
        'upsells'      => $upsells          // array of rows from upsell_tb
    ];
}

/**
 * Fetch the project_unique_id from GET parameters
 */
$projectUniqueId = $_GET['project_id'] ?? null;

// Initialize variables to hold data and error messages
$data = null;
$error = null;

// Only attempt to fetch data if project_unique_id is provided and database connection is successful
if ($projectUniqueId && isset($conn)) {
    try {
        $data = fetchStageFiveData($conn, $projectUniqueId);

        if (!$data) {
            $error = "No Stage Five data found for Project ID: " . htmlspecialchars($projectUniqueId);
        }

        //  echo '<pre>';
        //     print_r($data);
        //     echo '</pre>';
    } catch (Exception $e) {
        // Log the error (optional)
        error_log("Error fetching Stage Five data: " . $e->getMessage());

        // Set a user-friendly error message
        $error = "An error occurred while fetching Stage Five data. Please try again later.";
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


?>
