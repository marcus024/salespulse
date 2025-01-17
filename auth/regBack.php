<?php
include("db.php");
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $first_name = htmlspecialchars(trim($_POST['firstname']), ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars(trim($_POST['lastname']), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $company = htmlspecialchars(trim($_POST['company']), ENT_QUOTES, 'UTF-8');
        $position = htmlspecialchars(trim($_POST['position']), ENT_QUOTES, 'UTF-8');
        $role = htmlspecialchars(trim($_POST['role']), ENT_QUOTES, 'UTF-8');
        $gender = htmlspecialchars(trim($_POST['gender']), ENT_QUOTES, 'UTF-8');
        $password = $_POST['password'];
        $repeat_password = $_POST['repeatpass'];

        if (empty($first_name) || empty($last_name) || empty($email) || empty($company) || empty($position) || empty($role) || empty($gender) || empty($password) || empty($repeat_password)) {
            echo "<script>alert('Please fill in all the fields.'); window.history.back();</script>";
            exit;
        }

        if ($password !== $repeat_password) {
            echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.'); window.history.back();</script>";
            exit;
        }

        // Determine image based on gender
        $image = ($gender === 'Male') ? '../images/man.png' : (($gender === 'Female') ? '../images/woman.png' : 'default.png');

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $actual_password = $password;  

        $email_check_sql = "SELECT COUNT(*) FROM salesauth WHERE email = :email";
        $email_check_stmt = $conn->prepare($email_check_sql);
        $email_check_stmt->bindParam(':email', $email);
        $email_check_stmt->execute();
        if ($email_check_stmt->fetchColumn() > 0) {
            echo "<script>alert('Email is already registered.'); window.history.back();</script>";
            exit;
        }

        $user_id_sql = "SELECT COUNT(*) FROM salesauth";
        $user_id_stmt = $conn->prepare($user_id_sql);
        $user_id_stmt->execute();
        $user_count = $user_id_stmt->fetchColumn();
        $new_user_id = "UAS-SALESPULSE-USER-" . ($user_count + 1);

        // Insert user data into the database
        $sql = "INSERT INTO salesauth (user_id_current, firstname, lastname, email, company, position, role, gender, image, password, apass, status) 
                VALUES (:user_id_reg, :first_name, :last_name, :email, :company, :position, :role, :gender, :image, :hashed_password, :apass, 'NO')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id_reg', $new_user_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->bindParam(':apass', $actual_password);

        if ($stmt->execute()) {
            // Send confirmation email to the registered user
            $to = $email;
            $subject = "Registration Successful - SalesPulse";
            $message = "Hello $first_name $last_name,\n\nThank you for registering with SalesPulse. Your account has been successfully created, but it is not yet activated. Wait for another email notification to activate your account.\n\nBest regards,\nSalesPulse Team";
            // Check the domain of the recipient's email
            if (strpos($email, '@gmail.com') !== false) {
                $headers = "From: markantonyvc01@gmail.com";
            } elseif (strpos($email, '@uas.com.ph') !== false) {
                $headers = "From: macalipayan@uas.com.ph";
            } else {
                // Default case, you can change this to any other default email
                $headers = "From: default@domain.com";
            }

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('Registration successful! A confirmation email has been sent. The account is not yet activated. Please notify the admin to activate the account.'); window.location.href = '../index.php';</script>";
            } else {
                echo "<script>alert('Error: Unable to send email.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error: Unable to register. Please try again.'); window.history.back();</script>";
        }
    }
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
}

$conn = null;
?>
