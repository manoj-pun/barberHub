<?php
// Include database connection
include "database.php";
include "adminSidebar.php";  // Include sidebar
include "adminMainContent.php";  // Include main content
?>

<div class="content-container">
    <table class="gallery-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // Fetch all images from the gallery
            $query = "SELECT * FROM gallerys ORDER BY upload_date DESC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Decode the image data
                    $imageData = base64_encode($row['image_Data']);
                    echo '<tr>
                        <td><img src="data:' . $row['image_Type'] . ';base64,' . $imageData . '" alt="' . $row['imageTitle'] . '" class="gallery-image"></td>
                        <td>' . htmlspecialchars($row['imageTitle']) . '</td>
                        <td>' . htmlspecialchars($row['imageDescription']) . '</td>
                        <td class="edit-delete-button">
                            <button onclick="location.href=\'editGallerys.php?imageId=' . $row['imageId'] . '\'" class="edit-button">Edit</button>
                            <button 
                                onclick="window.location.href=\'deleteGallery.php?imageId=' . $row['imageId'] . '\'" class="delete-button">
                                Remove
                            </button>
                        </td>
                        </tr>';
                }
            } else {
                echo "<tr><td colspan='4'>No images found in the gallery.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>
