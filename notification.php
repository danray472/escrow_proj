<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escrow_project";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch notifications from the database
$sql_notifications = "SELECT * FROM notifications WHERE user_id = '{$_SESSION["user_id"]}' ORDER BY created_at DESC";
$result = $conn->query($sql_notifications);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .notification {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notification .message {
            font-weight: bold;
        }

        .notification .timestamp {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Notifications</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="notification">';
                echo '<p class="message">' . $row["message"] . '</p>';
                echo '<p class="timestamp">Received on: ' . $row["created_at"] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No notifications to display.</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
