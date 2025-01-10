<?php
session_start();
include("../auth/db.php"); // Ensure this points to your database connection file

// Check if the user is logged in
$user_id = $_SESSION['user_id_c'] ?? null;

if (!$user_id) {
    // Redirect to login if not authenticated
    header("Location: ../../login.php");
    exit;
}

// Fetch the project ID from the URL
$project_id = $_GET['project_id'] ?? null;

// Initialize the project variable
$project = null;

if ($project_id) {
    try {
        // Securely fetch the project details for the logged-in user
        $sql = "SELECT project_unique_id, company_name, account_manager, start_date, end_date, status,product_type,current_stage,client_type,source
                FROM projecttb
                WHERE project_unique_id = :project_id AND user_id_cur = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_STR); // Using PARAM_STR to handle alphanumeric IDs
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->execute();
        
        // Fetch the project details
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle database errors
        echo "<div style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit;
    }
}

// Redirect if the project is not found
if (!$project) {
    echo "<div style='color:red;'>Project not found or access denied.</div>";
    echo "<a href='projectList.php'>Back to Project List</a>";
    exit;
}
?>
