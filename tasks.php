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

// Retrieve available tasks from the database
$sql = "SELECT * FROM tasks WHERE status='open'";
$result = $conn->query($sql);

// Display available tasks
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
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
    echo "No tasks available.";
}

$conn->close();
?>
