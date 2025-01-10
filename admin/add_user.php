<?php
include("../auth/db.php");

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and trim the user input
        $first_name = htmlspecialchars(trim($_POST['firstname']), ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars(trim($_POST['lastname']), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $company = htmlspecialchars(trim($_POST['company']), ENT_QUOTES, 'UTF-8');
        $position = htmlspecialchars(trim($_POST['position']), ENT_QUOTES, 'UTF-8');
        $role = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');
        $password = $_POST['password'];

        // Validate that all required fields are provided
        if (empty($first_name) || empty($last_name) || empty($email) || empty($company) || empty($position) || empty($role) || empty($password)) {
            echo "<script>alert('Please fill in all the fields.'); window.history.back();</script>";
            exit;
        }


        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.'); window.history.back();</script>";
            exit;
        }

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the actual password into the database
        $actual_password = $password;  // Store the actual password (plaintext)

        // Prepare SQL query to check if the email is already registered
        $email_check_sql = "SELECT COUNT(*) FROM salesauth WHERE email = :email";
        $email_check_stmt = $conn->prepare($email_check_sql);
        $email_check_stmt->bindParam(':email', $email);
        $email_check_stmt->execute();
        // If the email is already registered
        if ($email_check_stmt->fetchColumn() > 0) {
            echo "<script>alert('Email is already registered.'); window.history.back();</script>";
            exit;
        }
        // Insert user data into the database with the 'NO' status (not activated)
        $sql = "INSERT INTO salesauth (firstname, lastname, email, company, position, role, password, apass, status) 
                VALUES (:firstname, :lastname, :email, :company, :position, :role, :hashed_password, :apass, 'NO')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $first_name);
        $stmt->bindParam(':lastname', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->bindParam(':apass', $actual_password);  // Bind the actual password (plaintext)

        if ($stmt->execute()) {
            // Notify admin to activate the account
            echo "<script>alert('Registration successful! The account is not yet activated. You are responsible for this activation'); window.location.href = 'admin.php';</script>";
        } else {
            echo "<script>alert('Error: Unable to register. Please try again.'); window.history.back();</script>";
        }
    }
} catch (PDOException $e) {
    // Handle errors
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
}

$conn = null;
?>
