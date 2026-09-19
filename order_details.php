<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];

if (!isset($_GET['orderID'])) {
    header("Location: orders.php");
    exit();
}

$orderID = $_GET['orderID'];

/* Get order information */
$stmt = $conn->prepare("
    SELECT orderID, totalAmount, orderDate, status
    FROM orders
    WHERE orderID = ? AND userID = ?
");

$stmt->bind_param("ii", $orderID, $userID);
$stmt->execute();

$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "Order not found.";
    exit();
}

/* Get order items */
$stmt = $conn->prepare("
    SELECT 
        oi.productID,
        oi.quantity,
        oi.price,
        p.name
    FROM order_items oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = ?
");

$stmt->bind_param("i", $orderID);
$stmt->execute();

$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Details - CUNA'S BAKERY</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>
    <div class="logo">
        <a href="index.php">CUNA'S BAKERY</a>
    </div>

    <ul class="links">
        <li><a href="index.php">HOME</a></li>
        <li><a href="items.php">ITEMS</a></li>
        <li><a href="orders.php">VIEW ORDERS</a></li>
    </ul>

    <div class="btns">
        <a href="items.php" class="order-now-btn">ORDER NOW</a>
        <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
    </div>
</nav>

<main>

    <div class="header">
        <h1>ORDER DETAILS</h1>
    </div>

    <div class="order-info">

        <h2>
            Order #<?= htmlspecialchars($order['orderID']) ?>
        </h2>

        <p>
            Date:
            <?= htmlspecialchars($order['orderDate']) ?>
        </p>

        <p>
            Status:
            <?= htmlspecialchars($order['status']) ?>
        </p>

    </div>

    <div class="table">
        <p>ITEM</p>
        <p>PRICE</p>
        <p>QUANTITY</p>
        <p>SUBTOTAL</p>
    </div>

    <?php if ($items->num_rows > 0): ?>

        <?php while ($item = $items->fetch_assoc()): ?>

            <?php
            $subtotal = $item['price'] * $item['quantity'];
            ?>

            <div class="order-items">

                <p>
                    <?= htmlspecialchars($item['name']) ?>
                </p>

                <p>
                    RM <?= number_format($item['price'], 2) ?>
                </p>

                <p>
                    <?= htmlspecialchars($item['quantity']) ?>
                </p>

                <p>
                    RM <?= number_format($subtotal, 2) ?>
                </p>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="cart-empty">
            <p>This order has no items.</p>
        </div>

    <?php endif; ?>

    <div class="order-total">

        <h3>
            Total:
            RM <?= number_format($order['totalAmount'], 2) ?>
        </h3>

    </div>

    <a href="orders.php">← Back to Orders</a>

</main>

</body>

</html>