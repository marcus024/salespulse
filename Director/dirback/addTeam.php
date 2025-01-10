<?php
include '../../auth/db.php';  
$response = [];

try {
    session_start();

    
    $head_user_id = $_SESSION['user_id_c'] ?? null;
    if (!$head_user_id) {
        throw new Exception("User not logged in.");
    }

    
    $input = json_decode(file_get_contents('php://input'), true);
    $team_user_id = $input['team_user_id'] ?? null;

    if (!$team_user_id) {
        throw new Exception("Team user ID is required.");
    }
 
    $query = "INSERT INTO team_tb (head_user_id, team_user_id) VALUES (:head_user_id, :team_user_id)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':head_user_id', $head_user_id, PDO::PARAM_STR);
    $stmt->bindParam(':team_user_id', $team_user_id, PDO::PARAM_STR);

    
    if ($stmt->execute()) {
        $response = [
            'success' => true,
            'message' => 'User successfully added to the team.',
        ];
    } else {
        throw new Exception("Failed to add user to the team.");
    }
} catch (Exception $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage(),
    ];
}
 
header('Content-Type: application/json');
echo json_encode($response);
?>
