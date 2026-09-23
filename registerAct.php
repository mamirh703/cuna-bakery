<?php
include "connect.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $address = trim($_POST["address"]);
    $phone = trim($_POST["phone"]);

    // Check if field are empty
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        $message = "Please fill in all fields.";
    }
    // Check password confirmation
    elseif ($password != $confirmPassword) {
        $message = "Password do not match.";
    } else {
        // Check if username already exist
        $sql = "SELECT userId FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already exists.";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users (username, password, address, phone, role)
                        VALUES (?, ?, ?, ?, 'member')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $hashedPassword, $address, $phone);

            if ($stmt->execute()) {
                echo "<script>alert ('Account Created Successfuly');
                            window.location='login.php';</script>";
            } else {
                echo "<script>alert ('Error creating account: " . $conn->error . "');
                        window.location='register.php';
                        </script>";
            }
        }
        $stmt->close();
    }
}
