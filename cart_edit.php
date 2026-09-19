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

// Grab the productID from the URL
$productID = isset($_GET['productID']) ? $_GET['productID'] : 0;

if ($productID <= 0) {
    echo "<script> 
            alert('PLEASE Select an item to edit'); 
            window.location='cart.php';
            </script>";
}

// Fetch this specific cart item
$stmt = $conn->prepare("SELECT cart.quantity, products.name, products.price 
                        FROM cart
                        INNER JOIN products ON cart.productID = products.productID
                        WHERE cart.userID = ? AND cart.productID = ?");
$stmt->bind_param("ii", $userID, $productID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script> 
            alert('PLEASE Select an item to edit'); 
            window.location='cart.php';
            </script>";
}

$product = $result->fetch_assoc();

//  Update Item
if (isset($_POST['update'])) {
    $newQty = max(1, $_POST['quantity']); // never below 1

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? 
                            WHERE userID = ? AND productID = ?");
    $stmt->bind_param("iii", $newQty, $userID, $productID);
    $stmt->execute();

    echo "<script> 
            alert('Item updated successfuly'); 
            window.location='cart.php';
            </script>";
}

// Delete Item
if (isset($_POST['delete_item'])) {
    $pid = (int)$_POST['productID'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE userID = ? AND productID = ?");
    $stmt->bind_param("ii", $userID, $pid);
    $stmt->execute();
    echo "<script>alert('Item has been removed');
            window.location='cart.php';
            </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h1>Edit Quantity</h1>
        </div>
        <form method="POST">
            <div class="cart-container">
                <div class="cart-items">
                    <div class="first-childe">
                        <img src="uploads/u good.jpg" alt="">
                        <p><?= htmlspecialchars($product['name']) ?></p>
                    </div>
                    <p>Current Quantity: <?= $product['quantity'] ?></p>
                    <p><label for="quantity">New Quantity:</label>
                        <input type="number" name="quantity" class="edit-qty" value="<?= $product['quantity'] ?>" min="1" required>
                    </p>
                </div>
                <hr><br>
                <div class="btn">
                    <button class="checkout-btn" type="submit" name="update">UPDATE</button>
                </div>
            </div>
        </form>
        <form method="POST" onsubmit="return confirm('Remove this item from your cart?');">
            <input type="hidden" name="productID" value="<?= $productID ?>">
            <div class="btn" style="margin: 1rem 3%;">
                <button type="submit" name="delete_item" class="checkout-btn">REMOVE ITEM</button>
            </div>
        </form>
    </main>
</body>

</html>
