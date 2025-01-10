<?php
include '../../../auth/db.php'; // Replace with your database connection file

header('Content-Type: application/json');

$response = ['hasCalendar' => false, 'calendarLink' => ''];

try {
    // Get input data from the frontend
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['userId'] ?? null;

    if (!$userId) {
        throw new Exception('User ID is required.');
    }

    // Query to check if the user already has a calendar link
    $query = "SELECT googleCal FROM gcalendar WHERE user_id_gCal = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response['hasCalendar'] = true;
        $response['calendarLink'] = $row['googleCal']; // Correct column name
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
