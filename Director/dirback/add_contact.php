<?php
session_start();  

include('../../auth/db.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $companyContact = $_POST['companyContact'];
   $nameContact = $_POST['nameContact'] ?? '';
    
    $nameContact = ucwords(strtolower($nameContact));
    $position = $_POST['position'];
    $gender = $_POST['gender'];
    $contactNum = $_POST['contactNum'];
    $email = $_POST['email'];
    $userId = $_SESSION['user_id_c'];  

    
    $query = "INSERT INTO contact_tb (company, name, position, gender, contact_number, email, user_id)
              VALUES (:companyContact, :nameContact, :position, :gender, :contactNum, :email, :userId)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':companyContact', $companyContact);
    $stmt->bindParam(':nameContact', $nameContact);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':contactNum', $contactNum);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':userId', $userId);

   
    if ($stmt->execute()) {
        
        echo "<script>
                alert('Contact information saved successfully.');
                window.location.href = '../contacts.php';  // Replace with your contact page URL
              </script>";
    } else {
       
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
