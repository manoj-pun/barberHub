<?php
session_start();
include "database.php"; // Ensure this file contains the database connection

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    echo "You need to log in to view your appointments.";
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch the latest upcoming appointment for the logged-in user
// Exclude appointments with status 'cancelled' or 'completed'
$query = "SELECT appointmentDate, timeSlot, appointmentId, status 
          FROM appointments 
          WHERE userId = ? AND status NOT IN ('canceled', 'completed') 
          ORDER BY appointmentDate ASC 
          LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

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
        <?php if ($appointment): ?>
            <p>You have an appointment on <?= htmlspecialchars($appointment['appointmentDate']) ?> at <?= htmlspecialchars($appointment['timeSlot']) ?>. Don't be late.</p>
            <div class="cancel-edit-button">
                <form method="POST" action="cancelAppointment.php">
                    <input type="hidden" name="appointmentId" value="<?= $appointment['appointmentId'] ?>">
                    <button type="submit" class="cancel-button">Cancel Appointment</button>
                </form>
            </div>
        <?php else: ?>
            <p>You have no upcoming appointments.</p>
        <?php endif; ?>
    </div>
    
    <?php include "footer.php"; ?>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const cancelButton = document.querySelector('.cancel-button');

    if (cancelButton) {
        cancelButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Show confirmation dialog
            const confirmCancel = confirm("Do you want to cancel your appointment?");
            
            if (confirmCancel) {
                const appointmentId = document.querySelector('input[name="appointmentId"]').value;

                // Send a request to cancel the appointment
                fetch('cancelAppointment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'appointmentId': appointmentId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Show the response message
                    if (data.success) {
                        location.reload(); // Reload the page to reflect the updated status
                    }
                })
                .catch(error => {
                    alert('An error occurred while canceling your appointment.');
                });
            }
        });
    }
});
</script>
</html>