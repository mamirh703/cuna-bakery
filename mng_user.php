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

$result = $conn->query("SELECT * FROM users ORDER BY userID");
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
            <li><a href="admin_add.php">ITEMS</a></li>
            <li><a href="admin_orders.php">VIEW ORDERS</a></li>
            <li><a href="mng_user.php">USERS</a></li>
        </ul>
        <div class="btns">
            <a href="items.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
        </div>
    </nav>
    <!-- Title -->
    <div class="header">
        <h1>USERS</h1>
    </div>
    <div class="table-wrapper">
        <table class="items-table">
            <thead>
                <tr>
                    <th>USER ID</th>
                    <th>USERNAME</th>
                    <th>ADDRESS</th>
                    <th>PHONE NUMBER</th>
                    <th>ROLE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
                <?php while ($row = $result->fetch_assoc()) {?>
                    <tbody>
                        <tr>
                            <td>#<?= htmlspecialchars($row['userID']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['address']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <a href="change_role.php?userID=<?= urlencode($row['userID']) ?>">
                                    Change Role
                                </a>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
        </table>
    </div>
</body>
</html>