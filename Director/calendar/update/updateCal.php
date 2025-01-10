<?php
include('../../../auth/db.php');
try {
  
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // For example, the front-end may send:
    // {
    //   "userId": 123,
    //   "outlookLink": "https://outlook.office.com/example",
    //   "googleLink": "https://calendar.google.com/example"
    // }

    // 4. Extract the variables
    $userId      = isset($data['userId']) ? $data['userId'] : null;
    $outlookLink = isset($data['outlookLink']) ? $data['outlookLink'] : '';
    $googleLink  = isset($data['googleLink']) ? $data['googleLink'] : '';

    // Simple validation (check userId)
    if (empty($userId)) {
        // Return error if no userId
        http_response_code(400);
        echo json_encode(["message" => "No userId provided."]);
        exit;
    }

    $sqlOutlook = "UPDATE calendar
                   SET outlookCal = :outlookLink
                   WHERE user_id = :userId";
    $stmtOutlook = $conn->prepare($sqlOutlook);
    $stmtOutlook->bindParam(':outlookLink', $outlookLink);
    $stmtOutlook->bindParam(':userId', $userId);
    $stmtOutlook->execute();

    // 6. Update Google link in `gcalendar`
    $sqlGoogle = "UPDATE gcalendar
                  SET googleCal = :googleLink
                  WHERE user_id_gCal = :userId";
    $stmtGoogle = $conn->prepare($sqlGoogle);
    $stmtGoogle->bindParam(':googleLink', $googleLink);
    $stmtGoogle->bindParam(':userId', $userId);
    $stmtGoogle->execute();

    // 7. Respond with success
    http_response_code(200);
    echo json_encode(["message" => "Calendar links updated successfully."]);

} catch (PDOException $e) {
    // Handle any DB error
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
