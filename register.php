<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form method="POST" action="register.php">

    <label>Username:</label><br>
    <input type="text" name="username" required>
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>
    <br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirmPassword" required>
    <br><br>

    <label>Address:</label><br>
    <textarea name="address" rows="4" required></textarea>
    <br><br>

    <label>Phone Number:</label><br>
    <input type="tel" name="phone" required>
    <br><br>

    <button type="submit">Register</button>

</form>

</body>
</html>