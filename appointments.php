<?php
include "database.php";  // Include the database connection file

// Check if the request is an AJAX request
if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];

    // Update the status in the database
    $query = "UPDATE appointments SET status = ? WHERE appointmentId = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));  // Handle prepare error
    }

    mysqli_stmt_bind_param($stmt, "si", $status, $appointmentId);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";  // Send success response
    } else {
        echo "error: " . mysqli_stmt_error($stmt);  // Output the error message for debugging
    }
    exit;  // End script execution after handling the AJAX request
}

// If it's not an AJAX request, continue rendering the HTML
include "adminSidebar.php";
include "adminMainContent.php";

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
    <title>Appointments</title>
    <style>
        .status-button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        .complete {
            background-color: green;
        }
        .completed {
            background-color: gray;
        }
        .cancelled {
            background-color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <script>
        // Function to handle the completion status update via AJAX
        function updateStatus(appointmentId, event) {
    event.preventDefault();  // Prevent the default button behavior (e.g., page reload)

    // Show confirmation dialog
    var confirmation = confirm("Are you sure you want to mark this appointment as completed?");

    if (confirmation) {
        $.ajax({
            url: '',  // Empty URL means the request will be sent to the current file
            type: 'POST',
            data: {
                appointmentId: appointmentId,
                status: 'completed'  // New status to update in the database
            },
            success: function(response) {
                if (response === 'success') {
                    // Update the button and status text
                    $('#status-' + appointmentId).text('Completed').removeClass('complete').addClass('completed').prop('disabled', true);

                    // Show a success message
                    alert('Appointment marked as completed!');
                } else {
                    alert('Error updating status: ' + response);  // Show specific error message from PHP
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX request failed: ' + error);  // Show error details for debugging
            }
        });
    } else {
        // If the user clicks "No"
        alert("Appointment status update canceled.");
    }
}
    </script>
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
                        <?php
                        // Determine which button to display based on the status
                        $status = $row['status'];
                        $appointmentId = $row['appointmentId'];

                        if ($status === 'complete') {
                            echo '<button id="status-' . $appointmentId . '" class="status-button complete" onclick="updateStatus(' . $appointmentId . ', event)">Complete</button>';
                        } elseif ($status === 'completed') {
                            echo '<button id="status-' . $appointmentId . '" class="status-button completed" disabled>Completed</button>';
                        } elseif ($status === 'canceled') {
                            echo '<button id="status-' . $appointmentId . '" class="status-button cancelled" disabled>Cancelled</button>';
                        }
                        ?>
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