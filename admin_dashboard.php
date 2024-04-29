<?php
session_start();

// Check if admin is not logged in, then redirect to admin login page
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

// Database connection and task retrieval code remains the same
// Place your existing code here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
</head>
<body>
    <!-- Add your body content here -->
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .task {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: box-shadow 0.3s ease; /* Add transition for smooth effect */
        }

        .task:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add box-shadow on hover */
        }

        form {
            display: inline; /* Align the submit button horizontally */
        }

       /* Style for the verify button */
    .verify-button {
        background-color: #05c46b; /* Green background */
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    /* Style for the hover effect on the verify button */
    .verify-button:hover {
        background-color: #0be881; /* Lighter green background on hover */
    }

    /* Style for the decline button */
    .decline-button {
        background-color: #ff3f34; /* Red background */
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 5px;
        margin-left: 30px;
    }

    /* Style for the hover effect on the decline button */
    .decline-button:hover {
        background-color: #ff6348; /* Lighter red background on hover */
    }
        
    </style>
</head>
<body>
    <div class="container">
        <?php

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

        // Retrieve tasks assigned to users and not verified yet
        $sql_tasks = "SELECT tasks.*, users.username, users.email FROM tasks LEFT JOIN users ON tasks.writer_id = users.id WHERE tasks.status='assigned'";
        $result_tasks = $conn->query($sql_tasks);

        // If tasks are found, display them
        if ($result_tasks->num_rows > 0) {
            echo "<h2>Assigned Tasks</h2>";
            while ($row_task = $result_tasks->fetch_assoc()) {
                echo "<div class='task'>";
                echo "<h4>Title: " . $row_task["title"] . "</h4>";
                echo "<p>Username: " . $row_task["username"] . "</p>";
                echo "<p>Email: " . $row_task["email"] . "</p>";
                echo "<p>Description: " . $row_task["description"] . "</p>";
                echo "<p>User ID: " . $row_task["writer_id"] . "</p>";
                echo "<p>Budget: $" . $row_task["budget"] . "</p>";
                echo "<p>Deadline: " . $row_task["deadline"] . "</p>";
                echo "<form action='verify_task.php' method='post'>";
                echo "<input type='hidden' name='task_id' value='" . $row_task["id"] . "'>";
                echo "<input type='hidden' name='action' value='verify'>"; // Add action field for verification
                echo "<input class='verify-button' type='submit' value='Verify Task'>";
                echo "</form>";
                echo "<form action='verify_task.php' method='post'>";
                echo "<input type='hidden' name='task_id' value='" . $row_task["id"] . "'>";
                echo "<input type='hidden' name='action' value='decline'>"; // Add action field for declining
                echo "<input class='decline-button' type='submit' value='Decline Task'>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No tasks assigned to users.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
