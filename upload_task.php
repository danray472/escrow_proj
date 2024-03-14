<?php
session_start();
// Check if the user is logged in as a writer
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

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

// Handle task upload form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve task details from the form
    $task_id = $_POST["task_id"];
    $file_name = $_FILES["task_file"]["name"];
    $file_tmp = $_FILES["task_file"]["tmp_name"];

    // Move uploaded file to uploads directory
    $uploads_dir = "uploads/";
    move_uploaded_file($file_tmp, "$uploads_dir/$file_name");

    // Update task status in the database to "pending verification"
    $sql_update_task = "UPDATE tasks SET status='pending verification', file_path='$uploads_dir/$file_name' WHERE id='$task_id'";
    if ($conn->query($sql_update_task) === TRUE) {
        echo "Task uploaded successfully!";
    } else {
        echo "Error uploading task: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Task</title>
</head>
<body>
    <h2>Upload Task</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="task_file">Upload Task File:</label><br>
        <input type="file" id="task_file" name="task_file" accept=".pdf, .doc, .docx"><br>
        <input type="hidden" name="task_id" value="<?php echo $_GET['task_id']; ?>">
        <input type="submit" value="Upload Task">
    </form>
</body>
</html>
