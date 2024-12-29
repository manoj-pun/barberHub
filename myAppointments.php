<?php
include 'database.php';
session_start(); // Start the session to access user data

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Query to get the user's appointments that are not completed
$query = "SELECT DISTINCT appointment_date, time_slot, status FROM appointments 
          WHERE user_id = ? 
          AND (status IS NULL OR TRIM(status) != 'completed') 
          ORDER BY appointment_date";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch all appointments for the logged-in user that are not completed
$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="./CSS/myAppointments.css">
</head>
<body>
    <?php include "header.php"; ?>
    <div class="my-appointments">
        <?php if (count($appointments) > 0): ?>
            <?php foreach ($appointments as $appointment): ?>
                <p>You have an appointment on <?php echo htmlspecialchars($appointment['appointment_date']); ?> at <?php echo htmlspecialchars($appointment['time_slot']); ?>. Don't be late.</p>
            <?php endforeach; ?>
            <div class="cancel-edit-button">
                <button class="cancel-button">Cancel Appointment</button>
                <a href="gallery.php?edit=1&appointment_id=<?php echo $appointment['id']; ?>" class="edit-button">Edit Appointment</a>
            </div>
        <?php else: ?>
            <p>You have no upcoming appointments.</p>
        <?php endif; ?>
    </div>
    
    <?php include "footer.php"; ?>
</body>
</html>
