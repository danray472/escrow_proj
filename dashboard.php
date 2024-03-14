<?php
session_start();
// Check if the user is logged in
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
    echo "<p>Email: $email</p>";
    echo "<p>Balance: $balance $</p>"; // Display user's balance
} else {
    echo "User not found.";
}

// Retrieve tasks assigned to the user
$sql_tasks = "SELECT * FROM tasks WHERE writer_id='$user_id'";
$result_tasks = $conn->query($sql_tasks);

echo "<h3>Your Tasks</h3>";
if ($result_tasks->num_rows > 0) {
    while ($row_task = $result_tasks->fetch_assoc()) {
        echo "<div>";
        echo "<h4>" . $row_task["title"] . "</h4>";
        echo "<p>Description: " . $row_task["description"] . "</p>";
        echo "<p>Budget: $" . $row_task["budget"] . "</p>";
        echo "<p>Deadline: " . $row_task["deadline"] . "</p>";
        echo "<p>Status: " . $row_task["status"] . "</p>";
        echo "</div>";
    }
} else {
    echo "No tasks assigned.";
}

// Retrieve payments made to the user
$sql_payments = "SELECT * FROM payments WHERE user_id='$user_id'";
$result_payments = $conn->query($sql_payments);

echo "<h3>Your Payments</h3>";
if ($result_payments->num_rows > 0) {
    while ($row_payment = $result_payments->fetch_assoc()) {
        echo "<div>";
        echo "<p>Task ID: " . $row_payment["task_id"] . "</p>";
        echo "<p>Amount: $" . $row_payment["amount"] . "</p>";
        echo "<p>Date: " . $row_payment["payment_date"] . "</p>";
        echo "</div>";
    }
} else {
    echo "No payments received.";
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
</head>
<body>
    <h3>Withdrawal</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="withdraw_amount">Enter amount to withdraw in US dollar:</label><br>
        <input type="number" id="withdraw_amount" name="withdraw_amount" min="0" max="<?php echo $balance . "$"; ?>" step="0.01" required><br>
        <input type="submit" value="Withdraw">
    </form>
    <a href="create_task.php">Create Task</a>
    <a href="logout.php">Logout</a>
</body>
</html>
