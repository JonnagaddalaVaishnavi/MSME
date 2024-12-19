<?php
session_start();
include('includes/db.php');
include('includes/header.php');;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Product Management</h1>
    <a href="add_product.php">Add Product</a>
    <!-- List products -->
    <?php
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $product['description']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
