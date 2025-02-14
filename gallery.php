<?php
include "database.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="./CSS/gallery.css">
</head>

<body>
    <?php include "header.php" ?>
    <div class="gallery-layout-container">
        <h2 class="our-gallery-heading">Choose Your Styles</h2>
        <div class="our-gallery">
            <?php
            $result = $conn->query("SELECT imageId, imageTitle, imageDescription, image_Data, image_Type FROM gallerys ORDER BY upload_date DESC");

            while ($row = $result->fetch_assoc()) {
                $imageData = base64_encode($row['image_Data']);
                $imageType = $row['image_Type'];
                $imageId = $row['imageId'];

                echo "
            <div class='gallery-grid' onClick=\"location.href='innerGallery.php?id=$imageId'\">
                <img class='gallery-image' src='data:$imageType;base64,$imageData' alt='{$row['imageTitle']}'>
                <div class='gallery-grid-info'>
                    <h3 class='gallery-title'>{$row['imageTitle']}</h3>
                    <p class='gallery-description'>{$row['imageDescription']}</p>
                </div>
            </div>";
            }
            ?>
        </div>
    </div>

    <?php include "footer.php" ?>
</body>