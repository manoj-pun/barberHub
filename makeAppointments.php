<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>
    <link rel="stylesheet" href="./CSS/makeAppointments.css">
</head>

<body>

    <?php include "header.php" ?>

    <div class="user-appointment-section">
        <div class="appointment-content">
            <!-- Static image for demonstration -->
            <div class="appointment-image-container">
                <img src="./IMAGES/braids.jpeg" alt="Gallery Image" class="appointment-image">
            </div>

            <!-- Display title and form -->
            <div class="appointment-details">
                <span class="appointment-title">Gallery Title</span>

                <!-- Appointment form -->
                <form id="appointmentForm" class="appointment-form">
                    <input type="hidden" name="gallery_id" value="1">
                    <input type="hidden" id="selected_time_slot" name="time_slot" value="">

                    <div class="form-group">
                        <label for="appointment_date" class="form-label">Date:</label>
                        <input type="date" id="appointment_date" name="appointment_date" class="form-input" required>
                    </div>

                    <div class="available-slots" id="timeSlots">
                        <div class="time-book-status">
                            <!-- Static time slots for demonstration -->
                            <div class="time-slot">
                                <span>6:00 - 6:30</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>6:30 - 7:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>7:00 - 7:30</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot" data-time-slot="7:00 - 7:30">
                                <span>7:30 - 8:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>8:30 - 9:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>9:00 - 9:30</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>9:30 - 10:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <div class="time-slot">
                                <span>10:30 - 11:00</span>
                                <button type="button" class="book-button">Book</button>
                            </div>
                            <!-- Add more time slots as needed -->
                        </div>
                    </div>

                    <!-- Error message if the user cannot book -->
                    <div class="form-group" id="errorMessage" style="display:none;">
                        <span class="error-message" style="color: red;">Please login to book an appointment.</span>
                    </div>

                    <div class="form-group">
                        <label for="comment" class="form-label">Comments:</label>
                        <textarea id="comment" name="comment" class="form-textarea" placeholder="Enter any additional details or preferences"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="book-button">Book Appointment</button>
                        <button type="submit" class="update-button">Update Appointment</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

    <!-- <script>
        const isUserLoggedIn = false; // Static user login status
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

                // If there's a previously selected button, reset its text and style
                if (selectedButton) {
                    selectedButton.textContent = 'Book';
                    selectedButton.classList.remove('booked-button');
                }

                // Set the current button as booked
                this.textContent = 'Booked';
                this.classList.add('booked-button');
                selectedButton = this;

                // Set the selected time slot in the hidden input field
                const selectedTimeSlot = this.closest('.time-slot').getAttribute('data-time-slot');
                document.getElementById('selected_time_slot').value = selectedTimeSlot;
            });
        });

        // Handle form submission
        appointmentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            if (!isUserLoggedIn) {
                errorMessage.style.display = 'block'; // Display error message if user is not logged in
                return;
            }

            // Submit the form data (here you would send it to the server)
            console.log('Form submitted successfully.');
        });
    </script> -->

    asdgsdg

</body>

</html>
