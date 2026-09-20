<?php
session_start();
include 'connect.php';

// --- Admin-only auth ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$allowed = ['pending', 'complete'];

// --- Handle status update ---
if (isset($_POST['update_status'])) {
    $orderID   = $_POST['orderID'] ?? '';
    $newStatus = $_POST['status'] ?? '';

    if ($orderID !== '' && in_array($newStatus, $allowed, true)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE orderID = ?");
        $stmt->bind_param("ss", $newStatus, $orderID);
        $stmt->execute();
    }

    header("Location: admin_order_details.php?orderID=" . urlencode($orderID) . "&updated");
    exit();
}

// --- Get orderID ---
$orderID = $_GET['orderID'] ?? '';
if ($orderID === '') {
    header("Location: admin_orders.php");
    exit();
}

// --- Fetch order (admin can view any user's order) ---
$stmt = $conn->prepare("
    SELECT orders.orderID, orders.totalAmount, orders.orderDate, orders.status,
    users.username
    FROM orders
    INNER JOIN users ON orders.userID = users.userID
    WHERE orders.orderID = ?
");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_orders.php");
    exit();
}
$order = $result->fetch_assoc();

// --- Fetch order items ---
$stmt = $conn->prepare("
    SELECT order_items.quantity, order_items.price,
    products.name, products.description,
    (order_items.quantity * order_items.price) AS subtotal
    FROM order_items
    INNER JOIN products ON order_items.productID = products.productID
    WHERE order_items.orderID = ?
    ORDER BY order_items.orderItemID
");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$items = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Order #<?= htmlspecialchars($order['orderID']) ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>ADMIN — ORDER DETAILS</h1>
    </div>
    <div class="order-container">
        <a href="admin_orders.php">← Back to All Orders</a>
        <?php if (isset($_GET['updated'])): ?>
            <p><strong>✓ Order status updated.</strong></p>
        <?php endif; ?>
        <h2>Order #<?= htmlspecialchars($order['orderID']) ?></h2><br>
        <h3>Customer Info</h3>
        <div class="order-info">
            <div class="order-meta">
                <p>Username: </p>
                <p class="value"><?= htmlspecialchars($order['username']) ?></p>
            </div>
            <div class="order-meta">
                <p>Date Placed: </p>
                <p class="value"><?= htmlspecialchars($order['orderDate']) ?></p>
            </div>
            <div class="order-meta">
                <p>Status: </p>
                <p class="value">
                    <span class="status <?= htmlspecialchars($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></span>
                </p>
            </div>
        </div>
        <h2>Items</h2>
    </div>
    <div class="table">
        <p>Item</p>
        <p>Price</p>
        <p>Qty</p>
        <p>Subtotal</p>
    </div>
    <?php if ($items->num_rows === 0): ?>
        <div class="cart-empty">
            <p>No items found</p>
        </div>
    <?php else: ?>
        <?php while ($item = $items->fetch_assoc()): ?>
            <div class="order-items">
                <p><?= htmlspecialchars($item['name']) ?></p>
                <p>RM <?= number_format($item['price'], 2) ?></p>
                <p>x<?= htmlspecialchars($item['quantity']) ?></p>
                <p>RM <?= number_format($item['subtotal'], 2) ?></p>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
    <div class="order-total">
        <h3>TOTAL : RM <?= number_format($order['totalAmount'], 2) ?></h3>
    </div>
    <div class="order-container">
        <h2>Update Status</h2>
        <form method="POST" action="admin_order_details.php">
            <div class="order-info">
                <div class="order-meta">
                    <input type="hidden" name="orderID" value="<?= htmlspecialchars($order['orderID']) ?>">
                    <label>
                        <input type="radio" name="status" value="pending"
                            <?= $order['status'] === 'pending' ? 'checked' : '' ?>>
                        Pending
                    </label>
                </div>
                <div class="order-meta">
                    <label>
                        <input type="radio" name="status" value="complete"
                            <?= $order['status'] === 'complete' ? 'checked' : '' ?>>
                        Complete
                    </label>
                </div>
                <div class="order-meta">
                    <button type="submit" class="checkout-btn" name="update_status">SAVE STATUS</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>