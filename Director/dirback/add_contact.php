<?php
session_start();  // Start the session to access session variables

// Assuming you have a database connection using PDO
include('../../auth/db.php');  // Replace with your actual DB connection file

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data and sanitize using PDO's prepare and bindParam
    $companyContact = $_POST['companyContact'];
    $nameContact = $_POST['nameContact'];
    $position = $_POST['position'];
    $gender = $_POST['gender'];
    $contactNum = $_POST['contactNum'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id_c'];  // Assuming the user ID is stored in session

    // Prepare the SQL query with placeholders
    $query = "INSERT INTO contact_tb (company, name, position, gender, contact_number, email, user_id)
              VALUES (:companyContact, :nameContact, :position, :gender, :contactNum, :email, :userId)";
    
    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters to the statement
    $stmt->bindParam(':companyContact', $companyContact);
    $stmt->bindParam(':nameContact', $nameContact);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':contactNum', $contactNum);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':userId', $userId);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Successfully inserted data, show a success pop-up and then redirect
        echo "<script>
                alert('Contact information saved successfully.');
                window.location.href = '../contacts.php';  // Replace with your contact page URL
              </script>";
    } else {
        // Error in insertion
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
