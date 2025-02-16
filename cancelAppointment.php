<?php
session_start();
include "database.php"; // Ensure this file contains the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    echo json_encode(["success" => false, "message" => "You need to log in to cancel your appointment."]);
    exit;
}

// Check if the appointment ID is set in the POST request
if (isset($_POST['appointmentId'])) {
    $appointmentId = $_POST['appointmentId'];

    // Prepare the delete query
    $query = "DELETE FROM appointments WHERE appointmentId = ? AND userId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $appointmentId, $_SESSION['user_id']); // Bind the appointment ID and user ID
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Appointment successfully canceled."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: Could not cancel the appointment."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No appointment ID provided."]);
}

$conn->close();
?>
