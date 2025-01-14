<?php
session_start();
include("../../auth/db.php");
$user_role = $_SESSION['role'] ?? 'default_role'; 
$user_id = $_SESSION['user_id_c'] ?? 'default user id';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $company_name = trim($_POST['company_name']);
        $account_manager = trim($_POST['account_manager']);
         
        $account_manager = preg_replace_callback('/\b\w/', function ($matches) {
            return strtoupper($matches[0]);
        }, strtolower($account_manager));
        $product_type = trim($_POST['product_type']);
        $start_date = trim($_POST['start_date']) ?: 'Not Yet Started';
        $end_date = trim($_POST['end_date']) ?: 'Not Yet Ended'; 
        $source = trim($_POST['source']); 
        $status = trim($_POST['status']) ?: 'Not Yet Started'; 
        $current_stage = trim($_POST['current_stage']) ?: 'Not Yet Started';  
        $client_type = trim($_POST['client_type']);

        if (
            empty($company_name) || empty($account_manager) || empty($product_type) ||
            empty($source) || empty($status) || empty($client_type)
        ) {
            echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
            exit;
        }
        $stmt = $conn->query("SELECT MAX(id) AS last_id FROM projecttb");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $last_id = $row['last_id'];
        $project_unique_id = "UASP" . ($last_id + 1);
        $sql = "INSERT INTO projecttb (project_unique_id, company_name, account_manager, product_type, start_date, end_date, source, status, current_stage, client_type, role,user_id_cur)
                VALUES (:project_unique_id, :company_name, :account_manager, :product_type, :start_date, :end_date, :source, :status, :current_stage, :client_type, :role, :user_id_c)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_unique_id', $project_unique_id);
        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':account_manager', $account_manager);
        $stmt->bindParam(':product_type', $product_type);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':source', $source);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':current_stage', $current_stage);
        $stmt->bindParam(':client_type', $client_type);
        $stmt->bindParam(':role', $user_role); 
        $stmt->bindParam(':user_id_c',$user_id);
        
        if ($stmt->execute()) {
            echo "<script>showNotification('Project added successfully!'); window.location.href = '../director.php';</script>";
        } else {
            echo "<script>showNotification('Failed to add project. Please try again.'); window.history.back();</script>";
        }

    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage(), 3, "../../logs/error.log");
    echo "<script>alert('An internal error occurred. Please try again later.'); window.history.back();</script>";
}
$conn = null;
?>
