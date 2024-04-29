<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Tasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .task {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .task h3 {
            margin-top: 0;
        }

        .task p {
            margin-bottom: 10px;
        }

        .task form {
            display: inline;
        }

        .task form input[type="submit"] {
            background-color: #05c46b;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .task form input[type="submit"]:hover {
            background-color: #0be881;
        }

        .no-tasks {
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h2>Available Tasks</h2>
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
    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        die("User ID not found in session. Please log in again.");
    }
    // Retrieve available tasks from the database
    $sql = "SELECT * FROM tasks WHERE status='open'";
    $result = $conn->query($sql);
    // Display available tasks
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='task'>";
            echo "<h3>" . $row["title"] . "</h3>";
            echo "<p>Description: " . $row["description"] . "</p>";
            echo "<p>Budget: $" . $row["budget"] . "</p>";
            echo "<p>Deadline: " . $row["deadline"] . "</p>";
            echo "<form action='accept_task.php' method='post'>";
            echo "<input type='hidden' name='task_id' value='" . $row["id"] . "'>";
            echo "<input type='submit' value='Accept Task'>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p class='no-tasks'>No tasks available.</p>";
    }
    $conn->close();
    ?>
</body>
</html>
