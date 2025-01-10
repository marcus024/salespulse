<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database configuration (db.php should contain the $conn object)
    include("../../../auth/db.php");

    // Collect form data from the POST request
    $projectUniqueId = isset($_POST['project_id']) ? $_POST['project_id'] : null;
    $currentStep = isset($_POST['current_step']) ? $_POST['current_step'] : null;

    // Validate required fields
    if (!$projectUniqueId || !$currentStep) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required fields: project_id or current_step.'
        ]);
        exit;
    }

    // Collect all other form data except 'project_id' and 'current_step'
    $formData = $_POST;
    unset($formData['project_id'], $formData['current_step']);

    // Prepare SQL query to update the 'stageone' table
    $updateFields = implode(", ", array_map(fn($col) => "$col = ?", array_keys($formData)));
    $query = "UPDATE stagetwo SET $updateFields WHERE project_unique_id = ?";

    try {
        // Use the existing PDO connection from the included db.php file ($conn)
        $stmt = $conn->prepare($query);

        // Bind parameters dynamically from form data
        $params = array_merge(array_values($formData), [$projectUniqueId]);
        // Execute the query
        $stmt->execute($params);

        // Check if any rows were updated
        if ($stmt->rowCount() > 0) {
            // Respond with success
            echo json_encode([
                'success' => true,
                'message' => 'Data updated successfully.'
            ]);
        } else {
            // If no rows were updated, notify the user
            echo json_encode([
                'success' => false,
                'message' => 'No data found to update or no changes made.'
            ]);
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo json_encode([
            'success' => false,
            'message' => 'Error updating data: ' . $e->getMessage()
        ]);
    }
} else {
    // Handle unsupported methods
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
}
?>
