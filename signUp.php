<?php

include "database.php"; 

$successMessage = ""; 
$emailError = ""; // Store email error message separately

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if inputs are empty
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Check if email is already registered
        $emailCheckQuery = "SELECT UserId FROM users WHERE Email = '$email'";
        $result = $conn->query($emailCheckQuery);

        if ($result->num_rows > 0) {
            $emailError = "The email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            // Insert data into the database
            $sql = "INSERT INTO users (Name, Email, Password) VALUES ('$name', '$email', '$hashedPassword')";
        
            if ($conn->query($sql) === TRUE) {
                $successMessage = "Account created successfully!";
            } else {
                $successMessage = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    
    // Close the connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./CSS/signUp.css">
</head>
<body>
    <div class="success-message"><?php echo $successMessage; ?></div>
    <div class="form-container">
        <h2>Sign Up</h2>
        

        <form id="signUpForm" method="POST" action="">
            <label class="name-label" for="name">Name:</label>
            <input type="text" class="name" id="name" name="name" placeholder="Enter your full name">
            <div id="nameError" class="error"></div>

            <label class="email-label" for="email">Email:</label>
            <input type="email" class="email" id="email" name="email" placeholder="Enter your email">
            <div id="emailError" class="error"><?php echo $emailError; ?></div> <!-- Display email error here -->

            <label class="password-label" for="password">Password:</label>
            <input type="password" class="password" id="password" name="password" placeholder="Enter your password">
            <div id="passwordError" class="error"></div>

            <button type="submit">Create Account</button>

            <span style="display:flex;justify-content:center">Already Registered? 
                <span onclick="location.href='login.php'" style="cursor: pointer; text-decoration: underline; color:#ffe400">Login</span>
            </span>
        </form>
    </div>

    <script>
        // Validate form before submitting
        document.getElementById('signUpForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Reset error messages
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';
            
            // Validate name
            const name = document.getElementById('name').value;
            if (name.trim() === '') {
                document.getElementById('nameError').textContent = 'Name is required.';
                isValid = false;
            }

            // Validate email
            const email = document.getElementById('email').value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (email.trim() === '') {
                document.getElementById('emailError').textContent = 'Email is required.';
                isValid = false;
            } else if (!emailPattern.test(email)) {
                document.getElementById('emailError').textContent = 'Invalid email format.';
                isValid = false;
            }

            // Validate password
            const password = document.getElementById('password').value;
            if (password.trim() === '') {
                document.getElementById('passwordError').textContent = 'Password is required.';
                isValid = false;
            } else if (password.length < 8) {
                document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long.';
                isValid = false;
            }

            // If any field is invalid, prevent form submission
            if (!isValid) {
                e.preventDefault();
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
            const message = document.querySelector(".success-message");
            if (message) {
                message.classList.add("hide");
            }
            }, 3000); 
        });
    </script>
</body>
</html>
