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

$stmt = $conn->prepare("SELECT orderID, totalAmount, orderDate, status 
                        FROM orders 
                        WHERE userID = ?
                        ORDER BY orderDate DESC");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$status = $_GET['status'] ?? 'all';

if ($status === 'pending' || $status === 'complete') {
    $stmt = $conn->prepare("SELECT orderID, totalAmount, orderDate, status 
                            FROM orders 
                            WHERE userID = ? AND status = ?
                            ORDER BY orderDate DESC");
    $stmt->bind_param("is", $userID, $status);
} else {
    $stmt = $conn->prepare("SELECT orderID, totalAmount, orderDate, status 
                            FROM orders 
                            WHERE userID = ?
                            ORDER BY orderDate DESC");
    $stmt->bind_param("i", $userID);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUNA'S BAKERY</title>
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
        <div class="logo"><a href="index.php">CUNA'S BAKERY</a></div>
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
    <!-- Main Content -->
    <main>
        <!-- Title -->
        <div class="header">
            <h1>ORDER</h1>
        </div>
        <!-- order links -->
        <div class="order">
            <ul class="links">
                <li><a href="orders.php?status=all">All Order</a></li>
                <li><a href="orders.php?status=pending">Pending</a></li>
                <li><a href="orders.php?status=complete">Complete</a></li>
            </ul>
        </div>
        <div class="table">
            <p>#ID</p>
            <p>DATE</p>
            <p>PRICE</p>
            <p>STATUS</p>
            <p>ACTION</p>
        </div>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($order = $result->fetch_assoc()) { ?>
                <div class="order-items">
                    <p>#<?= htmlspecialchars($order['orderID']) ?></p>
                    <p><?= $order['orderDate'] ?></p>
                    <p>RM <?= $order['totalAmount'] ?></p>
                    <p><?= $order['status'] ?></p>
                    <a href="order_details.php?orderID=<?= $order['orderID'] ?>">
                        View Details
                    </a>
                </div>
        <?php
            }
        } else {
            /* If no Order */
            echo "<div class='cart-empty'><p>You Do not Order yet</p></div>";
        }
        ?>
    </main>
</body>

</html>