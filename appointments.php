<?php
include "adminSidebar.php";
include "adminMainContent.php";

// Include the database connection file
include "database.php";  // Assuming your database connection is in this file

// Fetch data from the appointments table
$query = "SELECT appointments.appointmentId, users.Name AS customerName, gallerys.imageTitle, appointments.comment, appointments.appointmentDate, appointments.timeSlot, appointments.status 
          FROM appointments
          INNER JOIN users ON appointments.userId = users.UserId
          INNER JOIN gallerys ON appointments.galleryId = gallerys.imageId";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Style</th>
                    <th>Title</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Time-Slot</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['customerName']); ?></td>
                    <td><img src="./IMAGES/<?php echo htmlspecialchars($row['imageTitle']); ?>.jpeg" alt=""></td>
                    <td><?php echo htmlspecialchars($row['imageTitle']); ?></td>
                    <td><?php echo htmlspecialchars($row['comment']); ?></td>
                    <td><?php echo htmlspecialchars($row['appointmentDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['timeSlot']); ?></td>
                    <td>
                        <button class="completed"><?php echo $row['status'] === 'completed' ? 'Completed' : ''; ?></button>
                        <button class="cancelled"><?php echo $row['status'] === 'cancelled' ? 'Cancelled' : ''; ?></button>
                        <button class="complete"><?php echo $row['status'] === 'complete' ? 'Complete' : ''; ?></button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
