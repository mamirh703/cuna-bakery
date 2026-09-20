<?php
session_start();
include 'connect.php';

// Admin-only auth
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Optional filter: ?status=pending or ?status=complete
$filter = $_GET['status'] ?? 'all';

if ($filter === 'pending' || $filter === 'complete') {
    $stmt = $conn->prepare("
        SELECT orders.orderID, orders.totalAmount, orders.orderDate, orders.status, users.username
        FROM orders
        INNER JOIN users ON orders.userID = users.userID
        WHERE orders.status = ?
        ORDER BY orders.orderDate DESC
    ");
    $stmt->bind_param("s", $filter);
} else {
    $stmt = $conn->prepare("
        SELECT orders.orderID, orders.totalAmount, orders.orderDate, orders.status, users.username
        FROM orders
        INNER JOIN users ON orders.userID = users.userID
        ORDER BY orders.orderDate DESC
    ");
}
$stmt->execute();
$orders = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Orders</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo"><a href="admin.php">CUNA'S BAKERY</a></div>
        <ul class="links">
            <li><a href="admin.php">HOME</a></li>
            <li><a href="items.php">ITEMS</a></li>
            <li><a href="admin_orders.php">VIEW ORDERS</a></li>
        </ul>
        <div class="btns">
            <a href="items.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
        </div>
    </nav>
    <!-- Title -->
    <div class="header">
        <h1>ADMIN — ALL ORDERS</h1>
    </div>
    <!-- order links -->
    <div class="order">
        <ul class="links">
            <li><a href="admin_orders.php?status=all">All ORDER</a></li>|
            <li><a href="admin_orders.php?status=pending">PENDING</a></li>|
            <li><a href="admin_orders.php?status=complete">COMPLETE</a></li>
        </ul>
    </div>
    <div class="table">
        <p>Order ID</p>
        <p>Customer</p>
        <p>Date</p>
        <p>Total (RM)</p>
        <p>Status</p>
        <p>Action</p>
    </div>
    <?php if ($orders->num_rows === 0): ?>
        <div class="cart-empty">
            <p>No orders found</p>
        </div>
    <?php else: ?>
        <?php while ($o = $orders->fetch_assoc()): ?>
            <div class="order-items">
                <p>#<?= htmlspecialchars($o['orderID']) ?></p>
                <p><?= htmlspecialchars($o['username']) ?></p>
                <p><?= htmlspecialchars($o['orderDate']) ?></p>
                <p><?= number_format($o['totalAmount'], 2) ?></p>
                <p><?= htmlspecialchars($o['status']) ?></p>
                <p>
                    <a href="admin_order_details.php?orderID=<?= urlencode($o['orderID']) ?>">
                        View / Update
                    </a>
                </p>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    </table>
</body>

</html>