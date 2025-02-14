<?php
session_start();
include 'database.php'; // Ensure this file contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Both fields are required."]);
        exit;
    }

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT UserId, Name, Email, Password, Role FROM users WHERE Email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $name, $email, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $role;

            echo json_encode(["success" => true, "message" => "Login successful", "role" => $role]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid credentials."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No user found with this email."]);
    }

    $stmt->close();
    $conn->close();
}
?>
