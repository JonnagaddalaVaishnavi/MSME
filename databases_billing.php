<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create tables if they don't exist
function createTablesIfNeeded($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS `payment` (
        `id` int(100) NOT NULL AUTO_INCREMENT,
        `user_id` int(100) NOT NULL,
        `amount` DECIMAL(10,2) NOT NULL,
        `status` ENUM('pending', 'success', 'cancelled') NOT NULL,
        `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `user_info`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    );";

    if (!$conn->query($sql)) {
        die("Error creating table 'payment': " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `pay_upi` (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `upi_id` VARCHAR(20) NOT NULL,
        `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    if (!$conn->query($sql)) {
        die("Error creating table 'pay_upi': " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `pay_card` (
        `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `card_number` VARCHAR(16) NOT NULL,
        `expiry_date` VARCHAR(5) NOT NULL,
        `cvv` VARCHAR(3) NOT NULL,
        `bank_name` VARCHAR(50) NOT NULL,
        `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    if (!$conn->query($sql)) {
        die("Error creating table 'pay_card': " . $conn->error);
    }
}

// Function to insert card data into the pay_card table
function insertCardData($conn, $cardNumber, $expiryDate, $cvv, $bankName) {
    $sql = "INSERT INTO pay_card (card_number, expiry_date, cvv, bank_name)
            VALUES ('$cardNumber', '$expiryDate', '$cvv', '$bankName')";

    if (!$conn->query($sql)) {
        die("Error inserting card data: " . $conn->error);
    }
}

// Check if tables exist, if not create them
createTablesIfNeeded($conn);

// Assuming the card details are passed as POST parameters
$cardNumber = isset($_POST['card_number']) ? $_POST['card_number'] : '';
$expiryDate = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';
$cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';
$bankName = isset($_POST['bank_name']) ? $_POST['bank_name'] : '';

// Insert the card data
insertCardData($conn, $cardNumber, $expiryDate, $cvv, $bankName);

// Close connection
$conn->close();
?>
