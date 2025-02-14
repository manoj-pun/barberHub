
<?php
// Include database connection
include "database.php";

// Check if imageId is provided
if (isset($_GET['imageId'])) {
    $imageId = $_GET['imageId'];

    // Prepare and execute the delete query
    $query = "DELETE FROM gallerys WHERE imageId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        // Redirect to the gallery page after deletion
        header("Location: gallery.php");
        exit();
    } else {
        echo "Error deleting image: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request!";
}
?>
