<?php
// Include database connection
include "database.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = $_POST['imageId'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $imageData = null;
    $imageType = null;

    // Handle image upload (if a new image is uploaded)
    if (isset($_FILES['file-input']) && $_FILES['file-input']['error'] === UPLOAD_ERR_OK) {
        // Validate file type (optional but recommended)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Define allowed MIME types
        if (in_array($_FILES['file-input']['type'], $allowedTypes)) {
            $imageData = file_get_contents($_FILES['file-input']['tmp_name']);
            $imageType = $_FILES['file-input']['type'];
        } else {
            echo "Invalid image type!";
            exit();
        }
    } else {
        // If no new image is uploaded, keep the existing image data
        $query = "SELECT image_Data, image_Type FROM gallerys WHERE imageId = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $imageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $gallery = $result->fetch_assoc();
        $imageData = $gallery['image_Data'];
        $imageType = $gallery['image_Type'];
    }

    // Update the gallery in the database
    $query = "UPDATE gallerys SET imageTitle = ?, imageDescription = ?, image_Data = ?, image_Type = ? WHERE imageId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssbi", $title, $description, $imageData, $imageType, $imageId);
    $stmt->execute();

    // Redirect back to the gallery page
    header("Location: gallerys.php");
    exit();
}
?>
