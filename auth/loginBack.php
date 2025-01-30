<?php
session_start();
include("db.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize user input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Check if email and password are provided
        if (empty($email) || empty($password)) {
            echo "<script>alert('Email and password are required.'); window.history.back();</script>";
            exit;
        }

        // Prepare the SQL query to find the user
        $sql = "SELECT * FROM salesauth WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password and check account status
            if ($user['status'] === 'YES' && password_verify($password, $user['password'])) {
                // Prevent session fixation attacks
                session_regenerate_id(true);

                // Set session variables with limited scope
                $_SESSION['user_id_c'] = $user['user_id_current'];
                $_SESSION['user_name'] = htmlspecialchars($user['firstname'] . ' ' . $user['lastname'], ENT_QUOTES, 'UTF-8');
                $_SESSION['role'] = htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8');
                $_SESSION['position'] = htmlspecialchars($user['position'], ENT_QUOTES, 'UTF-8');
                $_SESSION['company'] = htmlspecialchars($user['company'], ENT_QUOTES, 'UTF-8');
                $_SESSION['email'] = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
                $_SESSION['gender'] = htmlspecialchars($user['gender'], ENT_QUOTES, 'UTF-8');
                $_SESSION['image'] = htmlspecialchars($user['image'], ENT_QUOTES, 'UTF-8');

                // Map role to user-friendly display names
                switch ($user['role']) {
                    case 'salesdirector':
                        $_SESSION['role_display'] = 'Sales and Marketing Director';
                        break;
                    case 'unithead':
                        $_SESSION['role_display'] = 'Business Unit Head';
                        break;
                    case 'salesmanager':
                        $_SESSION['role_display'] = 'Sales Manager';
                        break;
                    case 'accountmanager':
                        $_SESSION['role_display'] = 'Account Manager';
                        break;
                    case 'portal':
                        $_SESSION['role_display'] = 'Portal Manager';
                        break;
                    case 'central':
                        $_SESSION['role_display'] = 'Central Manager';
                        break;
                    default:
                        $_SESSION['role_display'] = 'Unknown Role';
                        break;
                }

                 // Insert login time and user ID into peak_tb
                $loginTime = date('Y-m-d H:i:s'); // Get the current date and time in 'YYYY-MM-DD HH:MM:SS' format
                $userId = $user['user_id_current']; // Get the current user's ID
                $insertQuery = "INSERT INTO peak_tb (logged_in, peak_user) VALUES (:logged_in, :peak_user)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->execute(['logged_in' => $loginTime, 'peak_user' => $userId]);

                // Implement login attempt tracking
                if (isset($_SESSION['login_attempts'])) {
                    unset($_SESSION['login_attempts']); // Reset login attempts on successful login
                }

                // Redirect based on role
                if ($user['role'] === 'central') {
                    header("Location: ../admin/spcentral.php");
                }  else if ($user['role'] === 'portal') {
                    header("Location: ../admin/spportal.php");
                }else {
                    header("Location: ../Director/director.php"); // Non-admin users redirected here
                }
                exit;
            } else {
                // Increment login attempts and handle lockout
                if (!isset($_SESSION['login_attempts'])) {
                    $_SESSION['login_attempts'] = 1;
                } else {
                    $_SESSION['login_attempts']++;
                }

                if ($_SESSION['login_attempts'] > 5) { // Limit login attempts
                    echo "<script>alert('Too many login attempts. Please try again later.'); window.history.back();</script>";
                    exit;
                }

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
    // Log the error securely
    error_log("Database error: " . $e->getMessage());

    // Display a generic error message
    echo "<script>alert('An unexpected error occurred. Please try again later.'); window.history.back();</script>";
    exit;
} catch (Exception $e) {
    // Handle unexpected errors
    error_log("General error: " . $e->getMessage());
    echo "<script>alert('An unexpected error occurred. Please try again later.'); window.history.back();</script>";
    exit;
}

// Close the connection
$conn = null;
?>
