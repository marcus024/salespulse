<?php
include('../../auth/db.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];  

    try {
         
        $stmt = $conn->prepare("SELECT current_stage FROM projecttb WHERE project_unique_id = :project_id");
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);  
        if ($result) {
            $current_stage = $result['current_stage'];  

             
            echo json_encode(['status' => 'success', 'current_stage' => $current_stage]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Project not found']);
        }

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }

    $conn = null;  
}
?>
