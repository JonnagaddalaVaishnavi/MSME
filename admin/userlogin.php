<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - User Login Data</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            max-width: 900px;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            background-color: #4a5568;
            color: #fff;
            padding: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-users {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #666;
        }
        .button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4a5568;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button a:hover {
            background-color: #2c5282;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>User Login Data</h2>
    </div>
    <div class="content">
        <table>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
            <?php
            // SQL query to fetch user login data
            $sql = "SELECT id, firstname, lastname, gender, email, password FROM user_info";
            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-users'>No users found</td></tr>";
            }
            $conn->close(); // Close database connection
            ?>
        </table>
    </div>
</div>

</body>
</html>
