<?php
include('../../auth/db.php');

// Get input data
$data = json_decode(file_get_contents('php://input'), true);
$contact_id = $data['contact_id'];
$field = $data['field'];
$value = $data['value'];

// Validate and sanitize inputs
if (!$contact_id || !$field || $value === null) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

// Whitelist of allowed fields
$allowedFields = ['name', 'company', 'position', 'email', 'contact_number'];
if (!in_array($field, $allowedFields)) {
    echo json_encode(['success' => false, 'error' => 'Invalid field']);
    exit;
}

try {
    // Use prepared statements to update the database
    $query = "UPDATE contact_tb SET $field = :value WHERE contact_id = :contact_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':value', $value);
    $stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database update failed']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
