<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

    <div class="login-container">

        <h2>Selamat Datang ke Cuna's Bakery</h2>

        <form action="loginAct.php" method="POST">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <br>
            <input type="submit" name="submit" value="Login" class="login-btn">

        </form>
        <p>
            Don't have an account?
            <a href="register.php">Register here</a>
        </p>
    </div>

</body>
</html>