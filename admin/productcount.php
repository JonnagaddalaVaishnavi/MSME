<?php
include('db.php');

// SQL query to fetch product details
$sql = "SELECT id, name, price, image FROM products";

// Execute query
$result = $con->query($sql);

$products = [];

if ($result->num_rows > 0) {
    // Fetch and store each product's details in an array
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($products);

// Close connection
$con->close();
?>


