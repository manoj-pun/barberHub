<?php
// Include database connection
include "database.php";

// Check if 'imageId' parameter is passed
if (isset($_GET['imageId'])) {
    $imageId = $_GET['imageId'];
    $query = "SELECT * FROM gallerys WHERE imageId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();
    $gallery = $result->fetch_assoc();

    // Check if image was found
    if (!$gallery) {
        echo "Image not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery</title>
    <link rel="stylesheet" href="./CSS/editGallery.css">
    <script>
        document.getElementById('file-input').addEventListener('change', function(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];

            // Check if a file was selected
            if (file) {
                const reader = new FileReader();

                // When the file is loaded, update the image source
                reader.onload = function(e) {
                    const imgElement = document.getElementById('default-upload-icon');
                    imgElement.src = e.target.result; // Set the new image source
                }

                // Read the selected file as a data URL
                reader.readAsDataURL(file);
            }
        });

        // Function to count words in the textarea
        function countWords(text) {
            return text.trim().split(/\s+/).filter(Boolean).length;
        }

        // Function to update word count and restrict words
        function updateWordCount() {
            const descriptionInput = document.getElementById('description-input');
            const wordCount = document.getElementById('word-count');
            const wordLimit = 50;
            const currentWordCount = countWords(descriptionInput.value);

            // Update word count display
            wordCount.textContent = `${currentWordCount}/${wordLimit}`;

            // Limit to 50 words
            if (currentWordCount > wordLimit) {
                const words = descriptionInput.value.trim().split(/\s+/).slice(0, wordLimit);
                descriptionInput.value = words.join(' ');
            }
        }

        // Event listener to update word count as the user types
        document.addEventListener('DOMContentLoaded', function() {
            const descriptionInput = document.getElementById('description-input');
            descriptionInput.addEventListener('input', updateWordCount);

            // Initial word count display
            updateWordCount();
        });
    </script>
</head>

<body>
    <!-- Form for Editing Gallery -->
    <form class="upload-section" action="updateGallery.php" method="POST" enctype="multipart/form-data">
        <h1 class="edit-heading">Edit Gallery</h1>

        <!-- Hidden Field for Image ID -->
        <input type="hidden" name="imageId" value="<?= $gallery['imageId'] ?>">

        <!-- Upload Image Section -->
        <div class="upload-image-form">
            <p class="upload-image-title">Upload Image</p>
            <label for="file-input" class="upload-image-label">
                <!-- Display existing image -->
                <img id="default-upload-icon" 
                     src="data:<?= $gallery['image_Type'] ?>;base64,<?= base64_encode($gallery['image_Data']) ?>" 
                     alt="Upload" 
                     class="upload-icon">
                <input type="file" name="file-input" id="file-input" class="upload-image-input" accept="image/*">
            </label>
        </div>

        <!-- Title Section -->
        <div class="upload-title-form">
            <p class="upload-title">Title</p>
            <input name="title" value="<?= htmlspecialchars($gallery['imageTitle']) ?>" class="upload-title-input" type="text" required>
        </div>

        <!-- Description Section -->
        <div class="upload-description-form">
            <p class="description-title">Description</p>
            <textarea name="description" class="upload-description-input" id="description-input"><?= htmlspecialchars($gallery['imageDescription']) ?></textarea>
            <p id="word-count" class="word-count">0/50</p>
        </div>

        <!-- Update Button -->
        <button type="submit" class="update-button">Update Gallery</button>
    </form>
</body>

</html>
