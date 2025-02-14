<?php
include "database.php";

if (isset($_POST['id'])) {
    $imageId = $_POST['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM gallerys WHERE imageId = ?");
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        echo "success"; // Send success response
    } else {
        echo "error"; // Send error response
    }
    $stmt->close();
} else {
    echo "invalid"; // Invalid request
}
?>
