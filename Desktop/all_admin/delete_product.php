<?php
session_start();
include('includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>
