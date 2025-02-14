<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="CSS/admin.css">
</head>

<body>

    <?php
    include "adminSidebar.php";
    include "adminMainContent.php";
    ?>

    <div class="table-container">
        <table class="styled-table">
            <thead class="table-header">
                <tr>
                    <th class="table-cell">Users</th>
                    <th class="table-cell">Email</th>
                    <th class="table-cell">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database
                $sql = "SELECT UserId, Name, Email FROM users WHERE Role != 'admin'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop through users and display them in the table
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='table-row' id='row_" . $row["UserId"] . "'>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row["Name"]) . "</td>";
                        echo "<td class='table-cell'>" . htmlspecialchars($row["Email"]) . "</td>";
                        echo "<td class='table-cell'><button class='remove-button' onclick='removeUser(" . $row["UserId"] . ")'>Remove</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='table-cell'>No users found</td></tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
    <script>
        function removeUser(userId) {
            if (confirm("Are you sure you want to remove this user?")) {
                fetch('removeUser.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'userId=' + userId
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === "success") {
                            document.getElementById("row_" + userId).remove();
                        } else {
                            alert("Error deleting user.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        }
    </script>


</body>

</html>