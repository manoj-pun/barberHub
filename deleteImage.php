<?php
include "database.php";

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM gallerys WHERE imageId = ?");
    $stmt->bind_param("i", $imageId);

    if ($stmt->execute()) {
        echo "<script>alert('Image deleted successfully!'); window.location.href='gallery.php';</script>";
    } else {
        echo "<script>alert('Failed to delete image.'); window.location.href='innerGallery.php?id=$imageId';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='gallery.php';</script>";
}
?>
