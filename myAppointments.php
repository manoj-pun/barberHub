<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/myAppointments.css">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="my-appointments">
        <p>You have an appointment on 2025-03-12 at 7-7:30. Don't be late.</p>
        <div class="cancel-edit-button">
            <button class="cancel-button">Cancel Appointment</button>
            <button onclick="location.href='editAppointment.php'" class="edit-button">Edit Appointment</button>
        </div>
        <p>You have no upcoming appointments.</p>
    </div>
    
    <?php include "footer.php"; ?>
</body>
</html>