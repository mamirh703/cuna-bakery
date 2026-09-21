<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <h2>Register ke <span class="brand">Cuna's Bakery</span></h2>
            <form action="registerAct.php" method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirmPassword" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required>
                </div><br>
                <button type="submit" class="login-btn">Register</button>
            </form>
        </div>
    </div>
</body>

</html>