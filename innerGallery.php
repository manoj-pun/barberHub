<?php
include "database.php";

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];

    // Fetch image details from the database
    $stmt = $conn->prepare("SELECT imageTitle, imageDescription, image_Data, image_Type FROM gallerys WHERE imageId = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $imageTitle = $row['imageTitle'];
        $imageDescription = $row['imageDescription'];
        $imageData = base64_encode($row['image_Data']);
        $imageType = $row['image_Type'];
    } else {
        echo "<p>Image not found.</p>";
        exit;
    }
    $stmt->close();
} else {
    echo "<p>Invalid request.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inner Gallery</title>
    <link rel="stylesheet" href="./CSS/innerGallery.css">
</head>

<body>
    <?php include "header.php"; ?>

    <div class="innerGallery-layout-container">
        <div class="innerGallery-layout">
            <div class="gallery-image-section">
                <img class="gallery-image" src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="<?php echo htmlspecialchars($imageTitle); ?>">
            </div>
            <div class="gallery-info-section">
                <div class="gallery-title">
                    <?php echo htmlspecialchars($imageTitle); ?>
                </div>
                <div class="gallery-image-description">
                    <div class="image-description">
                        <?php echo nl2br(htmlspecialchars($imageDescription)); ?>
                    </div>
                </div>

                <div class="gallery-appointment-button">
                    <button class="style-button" onclick="redirectToAppointment(<?php echo $imageId; ?>)">
                        Make Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>

<script>
    function redirectToAppointment(imageId) {
        window.location.href = `makeAppointments.php?id=${imageId}`;
    }

    function redirectToAppointment(imageId) {
        window.location.href = `makeAppointments.php?id=${imageId}`;
    }

    function deleteImage(imageId) {
        if (confirm("Are you sure you want to delete this image?")) {
            fetch('deleteImage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(imageId)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    alert("Image deleted successfully.");
                    window.location.href = "gallery.php"; // Redirect to gallery after deletion
                } else {
                    alert("Error deleting image.");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    }

</script>


</html>