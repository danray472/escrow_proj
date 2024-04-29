<?php
session_start();

// Set the timezone to UTC
date_default_timezone_set('Africa/Nairobi');

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

// Retrieve task ID and action from POST data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"]) && isset($_POST["action"])) {
    $task_id = $_POST["task_id"];
    $action = $_POST["action"]; // Retrieve the action from the form

    // Update task status based on action
    if ($action === "verify") {
        // Update task status to "completed"
        $sql_update_task = "UPDATE tasks SET status='completed' WHERE id='$task_id'";
        if ($conn->query($sql_update_task) === TRUE) {
            echo "Task verified successfully.";
            
            // Retrieve task information
            $sql_get_task_info = "SELECT * FROM tasks WHERE id='$task_id'";
            $result_task_info = $conn->query($sql_get_task_info);
            
            if ($result_task_info->num_rows == 1) {
                $row_task = $result_task_info->fetch_assoc();
                // Fetch the task title from the database
                $task_title = $row_task["title"];
                $user_id = $row_task["writer_id"];
                $amount = $row_task["budget"];
                
                // Use current date and time as the payment date
                $date = date("Y-m-d H:i:s");
                
                // Insert notification into notifications table
                $notification_message = "Your task \"$task_title\" (ID: $task_id) was verified, and you have received $amount on $date.";
                $sql_insert_notification = "INSERT INTO notifications (user_id, message, created_at) VALUES ('$user_id', '$notification_message', '$date')";
                if ($conn->query($sql_insert_notification) === TRUE) {
                    echo " Notification inserted successfully.";
                } else {
                    echo " Error inserting notification: " . $conn->error;
                }
                
                // Insert payment record into payments table
                $sql_insert_payment = "INSERT INTO payments (user_id, task_id, amount, payment_date) VALUES ('$user_id', '$task_id', '$amount', '$date')";
                if ($conn->query($sql_insert_payment) === TRUE) {
                    // Payment made successfully, update user's balance
                    $sql_update_balance = "UPDATE users SET balance = balance + '$amount' WHERE id='$user_id'";
                    if ($conn->query($sql_update_balance) === TRUE) {
                        echo " Balance updated successfully.";
                    } else {
                        echo " Error updating balance: " . $conn->error;
                    }
                } else {
                    echo " Error inserting payment record: " . $conn->error;
                }
            } else {
                echo " Error retrieving task information.";
            }
        } else {
            echo " Error updating task status: " . $conn->error;
        }
    } elseif ($action === "decline") {
        // Update task status to "open"
        $sql_update_task = "UPDATE tasks SET status='open' WHERE id='$task_id'";
        if ($conn->query($sql_update_task) === TRUE) {
            echo "Task declined successfully.";
        } else {
            echo " Error updating task status: " . $conn->error;
        }
    }
}

$conn->close();
?>
