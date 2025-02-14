<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/admin.css">
</head>

<body>
    <div class="sidebar-section">
        <div class="logo-section">
            <span class="logo">barberHub</span>
        </div>
        <div class="users-section">
            <button class="users" onclick="location.href='users.php'">Users</button>
        </div>
        <div class="appointments-section">
            <button class="appointments" onclick="location.href='appointments.php'">Appointments</button>
        </div>
        <div class="add-gallery-section" onclick="location.href='addToGallery.php'">
            <button class="add-gallery">Add to Gallery</button>
        </div>
        <div class="take-home">
            <button class="home-link" onclick="location.href='home.php'">Home</button>
        </div>
    </div>
</body>

</html>