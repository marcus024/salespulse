<?php
include("../auth/db.php");  // Include your database connection file

// Check if the necessary parameters are provided
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    try {
        // Prepare the SQL query to update the status
        $sql = "UPDATE salesauth SET status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        // Execute the update query
        if ($stmt->execute()) {
            // Send email notification
            $user_sql = "SELECT email, firstname, lastname FROM salesauth WHERE id = :id";
            $user_stmt = $conn->prepare($user_sql);
            $user_stmt->bindParam(':id', $id);
            $user_stmt->execute();
            $user = $user_stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Set the subject and message for the notification email
                $to = $user['email'];  // Change to the email where notifications should be sent
                $subject = "Your Account is now Activated";
                $status_message = $status === 'YES' ? 'activated' : 'deactivated';
                $login_link = $status === 'YES' ? "\n\nYou can log in now at: SalesPulse(https://lightyellow-tarsier-650234.hostingersite.com/)" : ''; // Add login link if activated
                $message = "Hello {$user['firstname']} {$user['lastname']},\n\nThe account for Sales Pulse  (Email: {$user['email']}) has been {$status_message}." . $login_link . "\n\nBest regards,\nWorkforce NextGen";
                // Check the domain of the recipient's email
                if (strpos($to, '@gmail.com') !== false) {
                    $headers = "From: markantonyvc01@gmail.com";
                } elseif (strpos($to, '@uas.com.ph') !== false) {
                    $headers = "From: macalipayan@uas.com.ph";
                } else {
                    // Default case, you can change this to any other default email
                    $headers = "From: default@domain.com";
                }

                // Send the email
                if (mail($to, $subject, $message, $headers)) {
                    echo json_encode(["success" => true, "message" => "Status updated and notification email sent"]);
                } else {
                    echo json_encode(["success" => true, "message" => "Status updated, but failed to send email notification"]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "User not found"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update the status"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
