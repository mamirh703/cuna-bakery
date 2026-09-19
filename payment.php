<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
</head>
<body>

<h2>Payment</h2>

<p>This is a test payment gateway.</p>

<form action="create_order.php" method="POST">

    <button type="submit">
        Simulate Successful Payment
    </button>

</form>

</body>
</html>