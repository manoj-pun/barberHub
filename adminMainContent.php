<?php
session_start();
include 'database.php'; // Ensure database connection is included

// Check if the admin is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin details from the database
$userId = $_SESSION['user_id'];
$query = "SELECT Name FROM users WHERE UserId = ? AND Role = 'admin'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$adminName = $row ? explode(' ', trim($row['Name']))[0] : "Admin"; // Extract first name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <div class="main-content-section">
        <div class="manage-flex">
            <span class="admin-title">Admin Panel</span>
            <div class="admin-logout-button">
                <button id="adminButton" class="admin-button">
                    <?php echo htmlspecialchars($adminName); ?>
                </button>
                <button id="logoutButton" class="logout-button">Logout</button>
            </div>
        </div>
        <hr>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const adminButton = document.getElementById("adminButton");
            const logoutButton = document.getElementById("logoutButton");

            adminButton.addEventListener("click", function() {
                logoutButton.style.display = logoutButton.style.display === "block" ? "none" : "block";
            });

            logoutButton.addEventListener("click", function() {
                fetch('logout.php')
                    .then(() => location.href = 'login.php'); // Redirect after logout
            });
        });
    </script>
</body>
</html>
