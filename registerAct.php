<?php
    include "connect.php";
    
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == POST) {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"]
        $address = trim($_POST["address"])
        $phone = trim($_POST["phone"])

        // Check if field are empty
        if (empty($username) || empty($passwword) || empty($confirmPassword)){
            $message = "Please fill in all fields.";
        }
        // Check password confirmation
        elseif ($password != $confirmPassword) {
            $message = "Password do not match.";
        }
        else {
            // Check if username already exist
            $sql = "SELECT id FROM users WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "Username already exists.";
            }
            else {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user
                $sql = "INSERT INTO users (username, password, address, phone, role)
                        VALUES (?, ?, ?, ?, 'user')";
                $stmt = $conn->prepare($sql)
                $stmt->bind_param("ssss", $username, $hashedPassword, $address, $phone);
                
                if ($stmt->execute()){
                    $message = "Registration successful.";
                }
                else {
                    $message = "Registration failed.";
                }
            }
            $stmt->close();
        }
    }
?>  