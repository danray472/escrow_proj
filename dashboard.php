<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
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

// Retrieve user details from the database
$user_id = $_SESSION["user_id"];
$sql_user = "SELECT * FROM users WHERE id='$user_id'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $username = $row_user["username"];
    $email = $row_user["email"];
    $balance = $row_user["balance"]; // Retrieve user's balance
    // Display user details
    echo "<h2>Welcome, $username!</h2>";
    echo "<p class='user-details'>$email</p>";
    echo "<p class='user-details balance'>Balance: $balance $</p>"; // Display user's balance
} else {
    echo "User not found.";
}

// Retrieve tasks assigned to the user
$sql_tasks = "SELECT * FROM tasks WHERE writer_id='$user_id'";
$result_tasks = $conn->query($sql_tasks);

echo "<div class='tasks-section'>";
echo "<h3>Your Tasks</h3>";
if ($result_tasks->num_rows > 0) {
    while ($row_task = $result_tasks->fetch_assoc()) {
        echo "<div class='tasks-card'>";
        echo "<div class='task'>";
        echo "<h4>" . $row_task["title"] . "</h4>";
        echo "<p >Description: " . $row_task["description"] . "</p>";
        echo "<p >Budget: $" . $row_task["budget"] . "</p>";
        echo "<p >Deadline: " . $row_task["deadline"] . "</p>";
        echo "<p >Status: " . $row_task["status"] . "</p>";
        echo "</div>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<div class='user-message'>No tasks assigned.</div>";
}

// Retrieve payments made to the user
$sql_payments = "SELECT * FROM payments WHERE user_id='$user_id'";
$result_payments = $conn->query($sql_payments);

echo "<h3>Your Payments</h3>";
if ($result_payments->num_rows > 0) {
    while ($row_payment = $result_payments->fetch_assoc()) {
        echo "<div class='pay-section'>";
        echo "<div class='payments'>";
        echo "<p>Task ID: " . $row_payment["task_id"] . "</p>";
        echo "<p>Amount: $" . $row_payment["amount"] . "</p>";
        echo "<p>Date: " . $row_payment["payment_date"] . "</p>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div class='user-message'>No payments received.</div>";
}

// Handle withdrawal logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["withdraw_amount"])) {
    $withdraw_amount = $_POST["withdraw_amount"];
    if ($withdraw_amount <= $balance) {
        // Update user's balance after withdrawal
        $new_balance = $balance - $withdraw_amount;
        $sql_update_balance = "UPDATE users SET balance='$new_balance' WHERE id='$user_id'";
        if ($conn->query($sql_update_balance) === TRUE) {
            echo "<p>Withdrawal successful. Updated balance: $new_balance $</p>";
        } else {
            echo "Error updating balance: " . $conn->error;
        }
    } else {
        echo "<p>Insufficient balance for withdrawal.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color:grey;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column; /* Adjust layout to column */
            align-items: center; /* Center content horizontally */
            height: 100vh;
        }

        .content {
            width: 80%; /* Adjust width of content */
            margin-top: 20px; /* Add some space from the top */
        }

        h2 {
            text-align: center; /* Center user information */
        }

        .user-details{
            text-align: center;
        }

        h3 {
            margin-bottom: 10px;
            margin-top: 10px;
            margin-left: 20vw;
            padding: 10px;
        }

        .task {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
         margin-bottom: 10px;
         background-color: #fff;
        transition: box-shadow 0.3s ease; /* Add transition for smooth effect */
        }

        .task:hover{
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        padding: 12px;
        transition: box-shadow 0.3s ease;
        }

         .payment {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            transition: box-shadow 0.3s; /* Smooth transition for box-shadow */
        }

        .task:hover, .payment:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box-shadow on hover */
        }

        .withdrawal-form {
            margin-top: 20px;
        }

        .withdrawal-form label {
            display: block;
            margin-bottom: 5px;
        }

        .withdrawal-form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .withdrawal-form input[type="submit"] {
            background-color: #05c46b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .tasks-section{
            margin-left: 2vw;
            background-color: #dcdde1;
        }

        .tasks-card{
            padding: 20px; /* Adjust as needed */
            margin: 20px; /* Adjust as needed */
        }


        .pay-section{
            margin-left: 2vw;
            background-color: #dcdde1;
            padding: 5px;
        }

        .balance {
           font-weight: bold;
           color: #05c46b
        }

        .withdraw{
            color: #05c46b;
            font-weight: 800;
        }

        .user-message{
            margin-left: 4vw;
        }



        </style>
</head>
<body>
    
    <div class="container">
        <div class="content">
            <div class="withdrawal-form">
                <h3 class="withdraw">Withdraw</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="withdraw_amount">Enter amount to withdraw in US dollar:</label><br>
                    <input type="number" id="withdraw_amount" name="withdraw_amount" min="0" max="<?php echo $balance; ?>" step="0.01" required><br>
                    <input type="submit" value="Withdraw">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
