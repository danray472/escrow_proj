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

    // Retrieve client's current balance
    $sql_balance = "SELECT balance FROM users WHERE id='$client_id'";
    $result_balance = $conn->query($sql_balance);
    if ($result_balance->num_rows == 1) {
        $row_balance = $result_balance->fetch_assoc();
        $current_balance = $row_balance["balance"];
        
        // Check if the client has enough balance to create the task
        if ($current_balance >= $budget) {
            // Deduct task budget from client's balance
            $new_balance = $current_balance - $budget;

            // Update writer balance in the database
            $sql_update_balance = "UPDATE users SET balance='$new_balance' WHERE id='$client_id'";
            if ($conn->query($sql_update_balance) === TRUE) {
                // Proceed with task creation
                // SQL query to insert task data into the database
                $sql = "INSERT INTO tasks (title, description, budget, deadline, client_id) VALUES ('$title', '$description', '$budget', '$deadline', '$client_id')";

                if ($conn->query($sql) === TRUE) {
                    echo "Task created successfully!";
                    echo "<br";
                    echo "$budget" . "was deducted from your account";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error updating balance: " . $conn->error;
            }
        } else {
            echo "Insufficient balance to create the task.";
        }
    } else {
        echo "Error retrieving balance.";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .task-form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow effect */
            width: 400px;
        }

        .task-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .task-form label {
            display: block;
            margin-bottom: 5px;
        }

        .task-form input[type="text"],
        .task-form textarea,
        .task-form input[type="number"],
        .task-form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .task-form input[type="submit"] {
            background-color: #05c46b;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .task-form input[type="submit"]:hover {
            background-color: #0be881;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="task-form">
        <h2>Create Task</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="budget">Budget:</label>
            <input type="number" id="budget" name="budget" min="0" required>
            <label for="deadline">Deadline:</label>
            <input type="date" id="deadline" name="deadline" required>
            <input type="submit" value="Create Task">
        </form>
    </div>
</body>
</html>
