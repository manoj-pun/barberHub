<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="./CSS/header.css">
</head>

<body>
    <div class="header-layout-container">
        <div class="header-section">
            <div class="header-left-section">
                <span class="logo" onclick="location.href='home.php'">barberHub</span>
            </div>
            <div class="header-middle-section">
                <a class="home-link" href="./home.php">Home</a>
                <a class="gallery-link" href="./gallery.php">Gallery</a>
            </div>
            <div class="header-right-section">
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true): ?>
                    <span class="user-name" id="userName">
                        <?php 
                        // Get first name and capitalize the first letter
                        $firstName = explode(" ", $_SESSION['user_name'])[0]; 
                        echo ucfirst(strtolower($firstName)); 
                        ?>
                    </span>
                    <div class="view-appointment" id="viewAppointment">
                        <div onclick="location.href='myAppointments.php'" class="appointments">My Appointments</div>
                        <div class="logout" id="logoutButton">Logout</div>
                    </div>
                <?php else: ?>
                    <button class="login-button" onclick="location.href= 'login.php'" id="loginButton">Login</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const loginButton = document.getElementById("loginButton");
            const userName = document.getElementById("userName");
            const viewAppointment = document.getElementById("viewAppointment");
            const logoutButton = document.getElementById("logoutButton");

            let isLoggedIn = <?php echo isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] ? 'true' : 'false'; ?>;

            function updateUI() {
                if (isLoggedIn) {
                    loginButton.style.display = "none";
                    viewAppointment.style.display = "none"; // Hide initially
                } else {
                    loginButton.style.display = "block";
                    viewAppointment.style.display = "none";
                }
            }

            // Toggle visibility on username click
            userName?.addEventListener("click", function() {
                viewAppointment.style.display = viewAppointment.style.display === "block" ? "none" : "block";
            });

            // Logout button functionality
            logoutButton?.addEventListener("click", function() {
                fetch('logout.php')
                    .then(() => location.href = 'home.php');
            });

            updateUI();
        });
    </script>
</body>

</html>
