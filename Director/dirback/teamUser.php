<?php
include '../../auth/db.php'; // Adjust the path to your database connection

try {
    // Fetch all users except admin, concatenating firstname and lastname
    $query = "SELECT user_id_current, CONCAT(firstname, ' ', lastname) AS name, position FROM salesauth WHERE role != 'central'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return users as JSON
    header('Content-Type: application/json');
    echo json_encode($users);
} catch (PDOException $e) {
    // Return error message as JSON
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => $e->getMessage()]);
}
