<?php
include '../../../auth/db.php'; // Replace with your database connection file

header('Content-Type: application/json');

$response = ['success' => false];

try {
    // Get input data from the frontend
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['guserId'] ?? null; // Fetch user ID from the request body
    $calendarLink = $input['gcalendarLink'] ?? '';

    if (empty($userId)) {
        throw new Exception('User ID is required.');
    }

    if (empty($calendarLink)) {
        throw new Exception('Calendar link is required.');
    }

    // SQL query to insert or update the calendar link
    $query = "
        INSERT INTO gcalendar (user_id_gCal, googleCal) 
        VALUES (:user_id, :calendar_link)
        ON DUPLICATE KEY UPDATE googleCal = :calendar_link
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $stmt->bindParam(':calendar_link', $calendarLink, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        throw new Exception('Failed to save the calendar link.');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Error saving calendar link: " . $e->getMessage());
}

echo json_encode($response);
