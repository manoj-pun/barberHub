
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to Gallery</title>
    <link rel="stylesheet" href="./CSS/admin.css">
</head>

<body>

    <?php
    include "adminSidebar.php";
    include "adminMainContent.php";
    ?>

    <form class="upload-section" action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="upload-image-form">
            <p class="upload-image-title">Upload Image</p>
            <label for="file-input" class="upload-image-label">
                <img id="default-upload-icon" src="./IMAGES/upload_area.png" alt="Upload" class="upload-icon">
                <img id="uploaded-image" src="./IMAGES/upload_added.png" alt="Uploaded" class="upload-icon" style="display: none;">
                <input type="file" name="file-input" id="file-input" class="upload-image-input" accept="image/*" required>
            </label>
        </div>

        <div class="upload-title-form">
            <p class="upload-title">Title</p>
            <input name="title" placeholder="Enter Title" class="upload-title-input" type="text" required>
        </div>

        <div class="upload-description-form">
            <p class="description-title">Description</p>
            <textarea name="description" class="upload-description-input" id="description-input" oninput="limitWords()" placeholder="Enter Image Description"></textarea>
            <p id="word-count" class="word-count">0/100</p>
        </div>

        <button type="submit" class="upload-button">Upload</button>
    </form>

</body>

</html>

<script>
    // Change image when an image is uploaded
    document.getElementById('file-input').addEventListener('change', function(event) {
        var file = event.target.files[0]; // Get the selected file
        if (file) {
            // Show the uploaded image
            document.getElementById('uploaded-image').style.display = 'block';
            document.getElementById('default-upload-icon').style.display = 'none';
        } else {
            // Show the default image
            document.getElementById('default-upload-icon').style.display = 'block';
            document.getElementById('uploaded-image').style.display = 'none';
        }
    });

    // Limit words in description
    function limitWords() {
        const textarea = document.getElementById('description-input');
        const wordCountDisplay = document.getElementById('word-count');

        // Get the current value of the textarea and split it into an array of words
        const words = textarea.value.trim().split(/\s+/);

        // Limit the number of words to 100
        if (words.length > 100) {
            words.length = 100;
            textarea.value = words.join(' ');
        }

        wordCountDisplay.textContent = `${words.length}/100`;
    }
</script>




