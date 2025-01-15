<?php
session_start();
include("../../../auth/db.php"); 

$user_id = $_SESSION['user_id_c'] ?? null;

if (!$user_id) {
    header("Location: ../../../login.php");
    exit;
}

$project_id = $_GET['project_id'] ?? null;


$project = null;

if ($project_id) {
    try {
        
        $sql = "SELECT project_unique_id, company_name, account_manager, start_date, end_date, status,product_type,current_stage,client_type,source
                FROM projecttb
                WHERE project_unique_id = :project_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR); 
        $stmt->execute();
        
      
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit;
    }
}

if (!$project) {
    echo "<div style='color:red;'>Project not found or access denied.</div>";
    echo "<a href='projectList.php'>Back to Project List</a>";
    exit;
}
?>
