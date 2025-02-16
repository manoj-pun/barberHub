<?php
session_start();
include "database.php"; // Ensure this file contains the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    echo json_encode(['success' => false, 'message' => 'You need to log in to cancel an appointment.']);
    exit;
}

$userId = $_SESSION['user_id'];

if (isset($_POST['appointmentId'])) {
    $appointmentId = $_POST['appointmentId'];

    // Update the appointment status to "canceled"
    $query = "UPDATE appointments SET status = 'canceled' WHERE appointmentId = ? AND userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $appointmentId, $userId);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Your appointment has been canceled.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'An error occurred while canceling your appointment.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid appointment ID.']);
}
?>
