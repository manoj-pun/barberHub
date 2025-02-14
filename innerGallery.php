<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inner Gallery</title>
    <link rel="stylesheet" href="./CSS/innerGallery.css">
</head>

<body>
    <?php include "header.php" ?>

    <div class="innerGallery-layout-container">
        <div class="innerGallery-layout">
            <div class="gallery-image-section">
                <img class="gallery-image" src="./IMAGES/braids.jpeg" alt="Image Title">
            </div>
            <div class="gallery-info-section">
                <div class="gallery-title">
                    Braids
                </div>
                <div class="gallery-image-description">
                    <div class="image-description">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam assumenda quis possimus ipsa in provident quaerat explicabo sapiente dolorum iusto, facere iste non reprehenderit tempore soluta, ex accusantium doloremque. Rerum?
                    </div>
                </div>

                <div class="delete-control">
                    <button class="delete-button">Delete</button>
                </div>

                <div class="gallery-appointment-button">
                    <button class="style-button" onclick="location.href='makeAppointments.php'">Make appointment with the style</button>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>
</body>

</html>
