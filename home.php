<?php session_start();
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafePay Escrow</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h1>SafePay Escrow</h1>
        </div>
        <div class="menu-toggle">
            <!-- No checkbox here -->
            <label for="menu-toggle-checkbox">&#9776;</label>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php" target="content">Dashboard</a></li>
            <li><a href="create_task.php" target="content">Create-task</a></li>
            <li><a href="tasks.php" target="content">View-tasks</a></li>
            <li><a href="notification.php" target="content">Notifications</a></li>
            <li><a href="about.php" target="content">About</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php" target="content">Dashboard</a></li>
                <li><a href="create_task.php" target="content">Create Task</a></li>
                <li><a href="tasks.php" target="content">View Tasks</a></li>
                <li><a href="notification.php" target="content">Notifications</a></li>
                <li><a href="about.php" target="content">About</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <!-- Display dashboard content by default -->
            <iframe name="content" src="dashboard.php" frameborder="0" width="100%" height="100%"></iframe>
        </div>
    </div>

    <style>
     /* CSS styles for the menu bar */
nav {
    background-color: #05c46b; /* Brown color */
    color: white; /* White color */
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
}

.logo h1 {
    margin: 0;
    font-size: 24px;
    background-color: transparent; /* Remove background */
}

.menu-toggle {
    display: none;
    font-size: 24px;
}

.menu-toggle label {
    cursor: pointer;
}

.menu {
    display: flex; /* Use flexbox */
    height: 10px;
}

.menu li {
    margin-right: 20px; /* Add spacing between menu items */
    list-style: none; /* Remove bullets */
}

.menu li:last-child {
    margin-right: 0; /* Remove margin from the last menu item */
}

.menu li a {
    text-decoration: none;
    color: white;
    font-family: Arial, sans-serif;
    font-size: 18px;
    padding: 0 10px; /* Add padding to the links */
}




/* Add hover effect to links on desktop */
.menu li a:hover {
    color: black; /* Change color to black on hover */
}

/* Set color to black for active link on desktop */
.menu li a.active {
    color: black;
}

.container {
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 200px;
    display: none;
    height: 40px;
}

.content {
    flex: 1;
    padding: 20px;
    background-color: #f0f0f0; /* Light gray color */
    color: black; /* Black color */
    font-size: 20px; /* Increase the font size */
}

/* Media query for mobile responsiveness */
@media screen and (max-width: 768px) {
    .menu-toggle {
        display: block;
    }

    .menu {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 50px;
        left: 0;
        width: 50%; /* Adjusted width to 50% */
        background-color: #05c46b;
    }

    .menu.active {
        display: flex;
    }

    .menu li {
        margin: 0;
        padding: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
}

    </style>

    <script>
        // JavaScript to toggle the menu on mobile devices
        const menuToggle = document.querySelector('.menu-toggle label');
        const menu = document.querySelector('.menu');

        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('active');
        });

        // JavaScript to handle link clicks and active state
        const menuLinks = document.querySelectorAll('.menu li a');

        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove active class from all links
                menuLinks.forEach(link => {
                    link.classList.remove('active');
                });

                // Add active class to clicked link
                this.classList.add('active');

                // Close the menu on mobile devices
                menu.classList.remove('active');
            });
        });
    </script>
</body>
</html>
