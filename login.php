<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Cuna's Bakery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <h2>Selamat Datang ke<br><span class="brand">Cuna's Bakery</span></h2>
            <form action="loginact.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div><br>
                <button type="submit" name="submit" class="login-btn">Login</button>
            </form>
            <p class="register-link">
                Don't have an account?
                <a href="register.php">Register here</a>
            </p>
        </div>
    </div>
</body>

</html>