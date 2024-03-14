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

// Retrieve task ID from POST data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"])) {
    $task_id = $_POST["task_id"];

    // Update task status to "verified" in the tasks table
    $sql_update_task = "UPDATE tasks SET status='verified' WHERE id='$task_id'";
    if ($conn->query($sql_update_task) === TRUE) {
        // Task verification successful
        echo "Task verified successfully.";
        
        // Retrieve task information
        $sql_get_task_info = "SELECT * FROM tasks WHERE id='$task_id'";
        $result_task_info = $conn->query($sql_get_task_info);
        
        if ($result_task_info->num_rows == 1) {
            $row_task = $result_task_info->fetch_assoc();
            $user_id = $row_task["writer_id"];
            $amount = $row_task["budget"];
            
            // Insert payment record into payments table
            $sql_insert_payment = "INSERT INTO payments (user_id, task_id, amount, payment_date) VALUES ('$user_id', '$task_id', '$amount', NOW())";
            
            if ($conn->query($sql_insert_payment) === TRUE) {
                // Payment made successfully, update user's balance
                $sql_update_balance = "UPDATE users SET balance = balance + '$amount' WHERE id='$user_id'";
                if ($conn->query($sql_update_balance) === TRUE) {
                    echo "Balance updated successfully.";
                } else {
                    echo "Error updating balance: " . $conn->error;
                }
            } else {
                echo "Error inserting payment record: " . $conn->error;
            }
        } else {
            echo "Error retrieving task information.";
        }
    } else {
        echo "Error updating task status: " . $conn->error;
    }
}

$conn->close();
?>
