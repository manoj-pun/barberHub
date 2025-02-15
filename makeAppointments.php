<?php
// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and if the user_id is set in the session
$isUserLoggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

include "database.php";

// Handle form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax'])) {
    // Check if user is logged in and userId is set
    if ($isUserLoggedIn && $userId) {
        // Validate and sanitize input data
        $galleryId = intval($_POST['gallery_id']);
        $appointmentDate = $_POST['appointment_date'];
        $timeSlot = $_POST['time_slot'];
        $comment = $_POST['comment'];

        // Insert the appointment into the database
        $stmt = $conn->prepare("INSERT INTO appointments (userId, galleryId, appointmentDate, timeSlot, comment, status) VALUES (?, ?, ?, ?, ?, 'complete')");
        $stmt->bind_param("iisss", $userId, $galleryId, $appointmentDate, $timeSlot, $comment);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Appointment booked successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error booking appointment. Please try again.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please log in to book an appointment.']);
    }

    exit();
}

// Fetch image details logic remains the same
if (isset($_GET['id'])) {
    $imageId = $_GET['id'];
    // Fetch image details from the database
    $stmt = $conn->prepare("SELECT imageTitle, image_Data, image_Type FROM gallerys WHERE imageId = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $imageTitle = $row['imageTitle'];
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
    <title>Make Appointment</title>
    <link rel="stylesheet" href="./CSS/makeAppointments.css">
</head>

<body>
    <?php include "header.php"; ?>

    <div class="user-appointment-section">
        <div class="appointment-content">
            <!-- Display the image dynamically -->
            <div class="appointment-image-container">
                <img src="data:<?php echo $imageType; ?>;base64,<?php echo $imageData; ?>" alt="Gallery Image" class="appointment-image">
            </div>

            <!-- Display title dynamically -->
            <div class="appointment-details">
                <span class="appointment-title"><?php echo htmlspecialchars($imageTitle); ?></span>

                <form id="appointmentForm" class="appointment-form" method="POST" action="">
                    <input type="hidden" name="gallery_id" value="<?php echo $imageId; ?>">
                    <input type="hidden" id="selected_time_slot" name="time_slot" value="">

                    <div class="form-group">
                        <label for="appointment_date" class="form-label">Date:</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-input" required>
                    </div>

                    <div class="available-slots" id="timeSlots">
                        <div class="time-book-status">
                            <div class="time-slot" data-time-slot="6:00 - 6:30">
                                <span>6:00 - 6:30</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot" data-time-slot="6:30 - 7:00">
                                <span>6:30 - 7:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot" data-time-slot="7:00 - 7:30">
                                <span>7:00 - 7:30</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                        </div>
                    </div>

                    <!-- Error message for missing time slot -->
                    <div id="timeError" style="color: red; display: none; margin-top: 10px;">
                        <p>Time Slot is required.</p>
                    </div>

                    <div class="form-group">
                        <label for="comment" class="form-label">Comments:</label>
                        <textarea id="comment" name="comment" class="form-textarea" placeholder="Enter any additional details or preferences"></textarea>
                    </div>

                    <!-- Error message for non-logged-in users -->
                    <?php if (!$isUserLoggedIn): ?>
                        <div id="errorMessage" style="color: red;">
                            <p>Please login to continue.</p>
                        </div>
                    <?php endif; ?>

                    <!-- Book Appointment button (only for logged-in users) -->
                    <?php if ($isUserLoggedIn): ?>
                        <div class="form-group">
                            <button type="submit" class="book-button">Book Appointment</button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

</body>
<script>
    // Pass the PHP variable to JavaScript
    const isUserLoggedIn = <?php echo $isUserLoggedIn ? 'true' : 'false'; ?>;
    const bookedTimeSlots = ['6:30 - 7:00']; // Static booked time slots for demonstration

    // Get the current date and calculate tomorrow's date
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);

    // Format the date to YYYY-MM-DD format (required for the input type="date")
    const formattedDate = tomorrow.toISOString().split('T')[0];

    // Set the min attribute to the formatted date
    const appointmentDateInput = document.getElementById('appointment_date');
    appointmentDateInput.setAttribute('min', formattedDate);

    // Show available time slots when a date is selected
    const appointmentDate = document.getElementById('appointment_date');
    const timeSlots = document.getElementById('timeSlots');
    const errorMessage = document.getElementById('errorMessage');
    const timeError = document.getElementById('timeError');
    const appointmentForm = document.getElementById('appointmentForm');
    const bookButtons = document.querySelectorAll('.book-button');
    let selectedButton = null;

    // Event listener for date input
    appointmentDate.addEventListener('change', function() {
        if (this.value) {
            timeSlots.style.display = 'flex'; // Show the time slots
        } else {
            timeSlots.style.display = 'none'; // Hide if no date is selected
        }
    });

    // Add event listeners to each button
    bookButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Ignore clicks if the button is already booked
            if (this.disabled) {
                return;
            }

            // Only change the text and styling of the time-slot buttons, not the "Book Appointment" button in the form
            if (this.closest('.time-slot')) {
                // If there's a previously selected button, reset its text and style
                if (selectedButton) {
                    selectedButton.textContent = 'Book';
                    selectedButton.classList.remove('booked-button');
                }

                // Set the current button as booked
                this.textContent = 'Booked'; // This changes the button text
                this.classList.add('booked-button'); // This adds the 'booked' styling
                selectedButton = this;

                // Set the selected time slot in the hidden input field
                const selectedTimeSlot = this.closest('.time-slot').getAttribute('data-time-slot');
                document.getElementById('selected_time_slot').value = selectedTimeSlot;

                // Hide time slot error if a time slot is selected
                timeError.style.display = 'none';
            }
        });
    });

    appointmentForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting immediately

    // Check if the user is logged in
    if (!isUserLoggedIn) {
        errorMessage.style.display = 'block'; // Display error message if user is not logged in
        return;
    }

    // Validate time slot selection
    const selectedTimeSlot = document.getElementById('selected_time_slot').value;

    // Check if time slot is selected
    if (!selectedTimeSlot) {
        timeError.style.display = 'block'; // Show time slot error message
        return;
    } else {
        timeError.style.display = 'none'; // Hide time slot error message
    }

    // Prepare form data
    const formData = new FormData(appointmentForm);
    formData.append('ajax', true); // Add the flag to indicate AJAX submission

    // Make the AJAX request
    fetch('', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message); // Show success message
            appointmentForm.reset(); // Clear the form fields
            timeSlots.style.display = 'none'; // Hide time slots
        } else {
            alert(data.message); // Show error message
        }
    })
    .catch(error => {
        alert('An error occurred. Please try again.');
    });
});

// Event listener for book button clicks to select time slot
bookButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Ignore clicks if the button is already booked
        if (this.disabled) {
            return;
        }

        // Only change the text and styling of the time-slot buttons, not the "Book Appointment" button in the form
        if (this.closest('.time-slot')) {
            // If there's a previously selected button, reset its text and style
            if (selectedButton) {
                selectedButton.textContent = 'Book';
                selectedButton.classList.remove('booked-button');
            }

            // Set the current button as booked
            this.textContent = 'Booked'; // This changes the button text
            this.classList.add('booked-button'); // This adds the 'booked' styling
            selectedButton = this;

            // Set the selected time slot in the hidden input field
            const selectedTimeSlot = this.closest('.time-slot').getAttribute('data-time-slot');
            document.getElementById('selected_time_slot').value = selectedTimeSlot;

            // Hide time slot error if a time slot is selected
            timeError.style.display = 'none';
        }
    });
});

</script>

</html>