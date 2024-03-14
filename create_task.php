<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process task creation form submission
    // Connect to the database (replace with your database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "escrow_project";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the task creation form
    $title = $_POST["title"];
    $description = $_POST["description"];
    $budget = $_POST["budget"];
    $deadline = $_POST["deadline"];
    $client_id = $_SESSION["user_id"];

    // SQL query to insert task data into the database
    $sql = "INSERT INTO tasks (title, description, budget, deadline, client_id) VALUES ('$title', '$description', '$budget', '$deadline', '$client_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Task created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>
<body>
    <h2>Create Task</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="budget">Budget:</label><br>
        <input type="number" id="budget" name="budget" min="0" required><br>
        <label for="deadline">Deadline:</label><br>
        <input type="date" id="deadline" name="deadline" required><br>
        <input type="submit" value="Create Task">
    </form>
</body>
</html>
