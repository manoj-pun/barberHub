<?php
include "database.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["userId"])) {
        $userId = intval($_POST["userId"]);

        // Prepare the SQL query
        $sql = "DELETE FROM users WHERE UserId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
