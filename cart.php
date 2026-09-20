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

// Handle adding items to the cart
if (isset($_POST['add_to_cart'])) {

    $productID = $_POST['productID'];

    // If product is already in cart, increase quantity
    $stmt = $conn->prepare("SELECT quantity 
                                FROM cart 
                                WHERE userID = ? AND productID = ?");
    $stmt->bind_param("ii", $userID, $productID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE cart 
                                    SET quantity = quantity + 1 
                                    WHERE userID = ? AND productID = ?");
        $stmt->bind_param("ii", $userID, $productID);
        $stmt->execute();
    } else {
        // Product quantity doesn't exist
        $quantity = 1;

        $stmt = $conn->prepare("INSERT INTO cart (userID, productID, quantity)
                                    VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userID, $productID, $quantity);
        $stmt->execute();
    }
    header("Location: cart.php");
    exit();
}
$stmt = $conn->prepare("SELECT cart.productID, cart.quantity, products.name, products.price, products.image 
                                FROM cart
                                INNER JOIN products
                                    ON cart.productID = products.productID
                                WHERE cart.userID = ?
                                ORDER BY cart.productID");
$stmt->bind_param("i", $userID);
$stmt->execute();

$result = $stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&imgon_names=shopping_cart" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <a href="index.php">CUNA'S BAKERY</a>
        </div>
        <ul class="links">
            <li><a href="index.php">HOME</a></li>
            <li><a href="items.php">ITEMS</a></li>
        </ul>
        <div class="btns">
            <a href="items.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
        </div>
    </nav>
    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Shopping Cart</h1>
        </div>
        <!-- Method for Edit Functionality -->
        <form action="cart_edit.php" method="GET">
            <!-- Edit Button -->
            <div class="edit-btns">
                <button type="submit" class="edit-btn">EDIT</button>
            </div>
            <!-- Cart -->
            <div class="cart-container">
                <?php
                /* Check cart item */
                if (mysqli_num_rows($result) > 0) {
                    while ($product  = $result->fetch_assoc()) {
                        $subtotal = $product['price'] * $product['quantity'];
                        $total += $subtotal; ?>
                        <!-- Cart Items -->
                        <div class="cart-items">
                            <div class="first-childe">
                                <input type="radio" name="productID" value="<?= $product['productID'] ?>">
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                <p><?= htmlspecialchars($product['name']); ?></p>
                            </div>
                            <p>QTY: x<?= $product['quantity']; ?> </p>
                            <p>RM <?= number_format($subtotal, 2); ?> </p>
                        </div>
                        <hr>
                <?php }
                } else {
                    /* if Cart is Empty */
                    echo "<div class='cart-empty'><p>Cart Is Empty</p></div><hr>";
                } ?>
                <!-- Total Price -->
                <div class="total-price">
                    <h3>Total:</h3>
                    <h3><?= number_format($total, 2); ?> </h3>
                </div>
            </div>
        </form>
        <!-- Continue or Checkout Button -->
        <div class="down-btns">
            <a href="items.php" class="cont-btn">Continue Shopping</a><br><br>
            <form method="POST" action="checkout.php" onsubmit="return confirm('Place in Order?')">
                <button type="submit" name="checkout" class="checkout-btn">CHECKOUT</button>
            </form>
        </div>
    </main>
</body>

</html>
