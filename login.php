<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/login.css">
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <form id="loginForm">
            <label class="email-label" for="email">Email:</label>
            <input type="email" class="email" id="email" name="email" placeholder="Enter your email">
            <div id="emailError" class="error"></div>

            <label class="password-label" for="password">Password:</label>
            <input type="password" class="password" id="password" name="password" placeholder="Enter your password">
            <div id="passwordError" class="error"></div>

            <button type="submit">Login</button>

            <span style="display:flex;justify-content:center">
                Don't have an account?
                <span onclick="location.href='signUp.php'" style="cursor: pointer; text-decoration: underline; color:#ffe400">
                    Register
                </span>
            </span>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loginForm").addEventListener("submit", function(e) {
                e.preventDefault(); // Prevent form from refreshing the page

                let email = document.getElementById("email").value.trim();
                let password = document.getElementById("password").value.trim();
                let emailError = document.getElementById("emailError");
                let passwordError = document.getElementById("passwordError");

                // Reset previous errors
                emailError.textContent = "";
                passwordError.textContent = "";

                let isValid = true;

                if (email === "") {
                    emailError.textContent = "Email is required.";
                    isValid = false;
                }

                if (password === "") {
                    passwordError.textContent = "Password is required.";
                    isValid = false;
                }

                if (!isValid) return;

                // Send AJAX request to processLogin.php
                fetch("processLogin.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect based on role
                            if (data.role === "admin") {
                                window.location.href = "admin.php";
                            } else {
                                window.location.href = "home.php";
                            }
                        } else {
                            // Display error messages properly
                            if (data.message === "No user found with this email.") {
                                emailError.textContent = data.message;
                            } else if (data.message === "Invalid credentials.") {
                                passwordError.textContent = "Incorrect password.";
                            }
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });
    </script>
</body>

</html>