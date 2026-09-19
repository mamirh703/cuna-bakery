<?php
    session_start();

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("Location: login.php");
        exit();
    }

    $orderID = $_GET['orderID'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Successful</title>
</head>
<body>

<h2>Order Successful!</h2>

<p>Your order has been placed.</p>

<p>
    Order ID:
    <?php echo htmlspecialchars($orderID); ?>
</p>

<a href="index.php">Continue Shopping</a>

</body>
</html>