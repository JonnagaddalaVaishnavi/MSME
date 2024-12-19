<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "project"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create user_info table
$sql_user_info = "CREATE TABLE IF NOT EXISTS `user_info` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `username` varchar(100) NOT NULL,
    `firstname` VARCHAR(100) NOT NULL,
    `lastname` VARCHAR(100) NOT NULL,
    `gender` ENUM('male', 'female') NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql_user_info) === TRUE) {
    echo "Table user_info created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Insert data into user_info table
$sql_insert_user_info = "INSERT INTO `user_info` (`username`, `firstname`, `lastname`, `gender`, `email`, `password`) VALUES
('admin', 'Admin', 'Admin', 'Male', 'admin@gmail.com', 'admin');";

if ($conn->query($sql_insert_user_info) === TRUE) {
    echo "Data inserted into user_info successfully<br>";
} else {
    echo "Error inserting data: " . $conn->error;
}

// Create cart table
$sql_cart = "CREATE TABLE IF NOT EXISTS `cart` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `user_id` int(100) NOT NULL,
    `name` varchar(100) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `image` varchar(100) NOT NULL,
    `quantity` int(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql_cart) === TRUE) {
    echo "Table cart created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Create products table
$sql_products = "CREATE TABLE IF NOT EXISTS `mobiles` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `image` varchar(1000) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql_products) === TRUE) {
    echo "Table mobiles created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error;
}

// Insert data into products table
$sql_insert_products = "INSERT INTO `mobiles` (`name`, `price`, `image`) VALUES
('Xiaomi 13T', '57290', 'https://fdn2.gsmarena.com/vv/bigpic/xiaomi-13t.jpg'),
('Vivo x100', '69999', 'https://fdn2.gsmarena.com/vv/bigpic/vivo-x100.jpg'),
('Samsung Galaxy S23 FE', '34999', 'https://fdn2.gsmarena.com/vv/bigpic/samsung-galaxy-s23-fe.jpg'),
('Apple iPhone 15 Pro Max', '79599', 'https://fdn2.gsmarena.com/vv/bigpic/apple-iphone-15-pro-max.jpg'),
('Google Pixel 8 Pro', '98999', 'https://fdn2.gsmarena.com/vv/bigpic/google-pixel-8-pro.jpg'),
('Xiaomi Poco M6 Pro', '10000', 'https://fdn2.gsmarena.com/vv/bigpic/xiaomi-poco-m6-pro.jpg'),
('Realme Narzo 60x', '10350', 'https://fdn2.gsmarena.com/vv/bigpic/realme-narzo-60x-5g.jpg'),
('Realme 11 Pro', '23999', 'https://fdn2.gsmarena.com/vv/bigpic/realme-11-pro.jpg'),
('vivo V29e', '25999', 'https://fdn2.gsmarena.com/vv/bigpic/vivo-v29e-international.jpg'),
('Infinix Note 30 Pro', '11999', 'https://fdn2.gsmarena.com/vv/bigpic/infinix-note-30-pro.jpg'),
('Infinix GT 10 Pro', '22275', 'https://fdn2.gsmarena.com/vv/bigpic/infinix-gt10-pro-5g.jpg'),
('Motorola Edge 40', '26999', 'https://fdn2.gsmarena.com/vv/bigpic/motorola-edge-40.jpg'),
('Motorola Razr 40 Ultra', '44999', 'https://fdn2.gsmarena.com/vv/bigpic/motorola-razr-40-ultra.jpg'),
('Nokia 110 (2022)', '1849', 'https://fdn2.gsmarena.com/vv/bigpic/nokia-110-2022.jpg'),
('Nokia C210', '4299', 'https://fdn2.gsmarena.com/vv/bigpic/nokia-c210.jpg'),
('Huawei Mate 60 Pro', '84999', 'https://fdn2.gsmarena.com/vv/bigpic/huawei-mate-60-pro.jpg'),
('Huawei P60 Pro', '18999', 'https://fdn2.gsmarena.com/vv/bigpic/huawei-p60-pro.jpg'),
('OnePlus Open', '139999', 'https://fdn2.gsmarena.com/vv/bigpic/oneplus-open-10.jpg'),
('Oppo A2', '34221', 'https://fdn2.gsmarena.com/vv/bigpic/oneplus-11.jpg'),
('Oppo Reno10 Pro', '29949', 'https://fdn2.gsmarena.com/vv/bigpic/oppo-reno10-pro-international.jpg'),
('Tecno Camon 20 Pro', '19999', 'https://fdn2.gsmarena.com/vv/bigpic/tecno-camon20-pro.jpg');";

if ($conn->query($sql_insert_products) === TRUE) {
    echo "Data inserted into products successfully<br>";
} else {
    echo "Error inserting data: " . $conn->error;
}

$conn->close();
?>
