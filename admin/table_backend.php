<?php
// Include the database connection file
include("../auth/db.php");

try {
    // Fetch data from salesauth table
    $sql = "SELECT firstname, lastname, email, password, position, role, company, apass, status FROM salesauth";
    $stmt = $conn->query($sql);

    // Check if the query was successful
    if ($stmt) {
        // Check if there are rows returned
        if ($stmt->rowCount() > 0) {
            echo "<div style='color: green;'>Data fetched successfully!</div>";
            // You can fetch the data and display it in your table
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Displaying fetched data (you can customize this to your needs)
                echo "<div>First Name: " . $row['firstname'] . "</div>";
                echo "<div>Last Name: " . $row['lastname'] . "</div>";
                // Add other fields here
            }
        } else {
            echo "<div style='color: orange;'>No records found in the database.</div>";
        }
    } else {
        echo "<div style='color: red;'>Error in query execution.</div>";
    }
} catch (PDOException $e) {
    echo "<div style='color: red;'>Error: " . $e->getMessage() . "</div>";
}
?>
