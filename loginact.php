<?php
    include "connect.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Check hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

                if ($row['role'] == "admin") {
                    header("Location: admin.php");
                    exit();
                } 

                else {
                    header("Location: index.php");
                    exit();
                }

            } 
            else {
                echo "<script>alert('Invalid username or password.');
                        window.location='login.php';
                        </script>";
            }

        } 

        else {
            echo "<script>alert('Invalid username or password.');
                    window.location='login.php';
                    </script>";
        }
        mysqli_stmt_close($stmt);
    }
?>         