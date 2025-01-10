<?php
session_start();
include("db.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
        $password = $_POST['password'];

        // Prepare the SQL query to find the user
        $sql = "SELECT * FROM salesauth WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password and check account status
            if ($user['status'] === 'YES' && password_verify($password, $user['password'])) {
                // Set session variables
                session_regenerate_id(true);
                $_SESSION['user_id_c'] = $user['user_id_current'];
                $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['position'] = $user['position'];
                $_SESSION['company'] = $user['company'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['gender'] = $user['gender'];
                $_SESSION['image'] = $user['image'];

                // Map role to user-friendly display names
                switch ($user['role']) {
                    case 'itmember':
                        $_SESSION['role_display'] = 'IT Member';
                        break;
                    case 'ithead':
                        $_SESSION['role_display'] = 'IT Head';
                        break;
                    case 'director':
                        $_SESSION['role_display'] = 'Director';
                        break;
                    case 'saleshead':
                        $_SESSION['role_display'] = 'Sales Head';
                        break;
                    case 'salesmember':
                        $_SESSION['role_display'] = 'Sales Member';
                        break;
                    default:
                        $_SESSION['role_display'] = 'Unknown Role';
                        break;
                }

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/admin.php");
                } else {
                    header("Location: ../Director/director.php"); // Non-admin users redirected here
                }
                exit;
            } else {
                // Invalid credentials or inactive account
                echo "<script>alert('Invalid credentials or account not activated. Please contact your admin.'); window.history.back();</script>";
                exit;
            }
        } else {
            // User not found
            echo "<script>alert('Email or password is incorrect. Please try again.'); window.history.back();</script>";
            exit;
        }
    }
} catch (PDOException $e) {
    // Log the error and show a generic message
    error_log("Database error: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again later.'); window.history.back();</script>";
    exit;
}

// Close the connection
$conn = null;
?>
