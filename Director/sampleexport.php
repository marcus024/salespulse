<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow all origins
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

include('../auth/db.php'); // Ensure database connection is established

// Check if database connection is valid
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(["error" => "Database connection failed", "details" => $conn->connect_error]);
    exit;
}

// Fetch all product data from product_tb
$sql = "SELECT id, product, created_at, user_id, company FROM product_tb";
$result = $conn->query($sql);

$products = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $result->free();
} else {
    echo json_encode(["error" => "Query failed", "details" => $conn->error]);
    exit;
}

// Return JSON data
echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conn->close();
?>
