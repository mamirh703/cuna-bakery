<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}

$orderID = $_GET['orderID'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Order Successful!</h1>
    </div>

    <div class="form-container">
        <div class="add-form" style="gap: .5rem;">
            <h2>Your order has been placed.</h2>
            <h3>
                Order ID:
                <?php echo htmlspecialchars($orderID); ?>
            </h3>
            <div class="btn">
                <button class="checkout-btn" onclick="window.location='orders.php'">View Order</button>
            </div>
        </div>
    </div>
</body>

</html>
