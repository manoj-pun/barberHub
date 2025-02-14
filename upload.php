<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_FILES["file-input"]) && $_FILES["file-input"]["error"] == 0) {
        $imageType = $_FILES["file-input"]["type"];
        $imageData = file_get_contents($_FILES["file-input"]["tmp_name"]);

        $stmt = $conn->prepare("INSERT INTO gallerys (imageTitle, imageDescription, image_Data, image_Type, upload_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $title, $description, $imageData, $imageType);

        if ($stmt->execute()) {
            echo "<script>alert('Image uploaded successfully!'); window.location.href='gallery.php';</script>";
        } else {
            echo "<script>alert('Error uploading image.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please select a valid image.'); window.history.back();</script>";
    }

    $conn->close();
}
?>
