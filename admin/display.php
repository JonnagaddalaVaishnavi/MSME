<?php
include ('db.php');

$sql = "SELECT products1.*, categories.name AS category_name FROM products1 JOIN categories ON products.
  category_id = categories.id";
$result = $con->query($sql);

if (!$result) {
    echo "Error executing query: " . $con->error;
    // You may want to handle the error gracefully or terminate the script
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
            <th>Created At</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            echo "<td>" . $row['category_name'] . "</td>";
            echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "' width='100'></td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="add_product.php">Add Product</a>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
