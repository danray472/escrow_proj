<?php
// Start session
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

// Retrieve tasks assigned to users and not verified yet
$sql_tasks = "SELECT tasks.*, users.username, users.email FROM tasks LEFT JOIN users ON tasks.client_id = users.id WHERE tasks.status='assigned'";
$result_tasks = $conn->query($sql_tasks);

// If tasks are found, display them
if ($result_tasks->num_rows > 0) {
    echo "<h2>Assigned Tasks</h2>";
    while ($row_task = $result_tasks->fetch_assoc()) {
        echo "<div>";
        echo "<p>Username: " . $row_task["username"] . "</p>";
        echo "<p>Email: " . $row_task["email"] . "</p>";
        echo "<h3>Title: " . $row_task["title"] . "</h3>";
        echo "<p>Description: " . $row_task["description"] . "</p>";
        echo "<p>User ID: " . $row_task["id"] . "</p>";
        echo "<p>Budget: $" . $row_task["budget"] . "</p>";
        echo "<p>Deadline: " . $row_task["deadline"] . "</p>";
        echo "<form action='verify_task.php' method='post'>";
        echo "<input type='hidden' name='task_id' value='" . $row_task["id"] . "'>";
        echo "<input type='submit' value='Verify Task'>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No tasks assigned to users.</p>";
}

// Close the database connection
$conn->close();
?>
