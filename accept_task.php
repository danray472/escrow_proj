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

// Retrieve writer ID from session
if(isset($_SESSION["user_id"])) {
    $writer_id = $_SESSION["user_id"];
} else {
    // Handle case where user ID is not set in session
    // Redirect the user to log in again or display an error message
    exit("User ID not found in session. Please log in again.");
}

// Retrieve task ID from form submission
$task_id = $_POST["task_id"];

// Update the task status and assign writer
$sql = "UPDATE tasks SET status='assigned', writer_id='$writer_id' WHERE id='$task_id'";

if ($conn->query($sql) === TRUE) {
    echo "Task accepted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
