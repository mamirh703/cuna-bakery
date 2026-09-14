<?php
session_start();
include 'connect.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding items to the cart
if (isset($_POST['add_to_cart'])) {

    $product_id = $_POST['productID'];

    // If product is already in cart, increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Shopping Cart</title>
</head>

<body>

    <h2>Your Cart</h2>

    <a href="index.php">Continue Shopping</a>

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {

        $total = 0;

        foreach ($_SESSION['cart'] as $id => $quantity) {

            // Prepared statement
            $stmt = $conn->prepare(
                "SELECT * FROM products WHERE productID = ?"
            );

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {

                $subtotal = $product['price'] * $quantity;
                $total += $subtotal;

                echo "<div>";
                echo "<p>";
                echo htmlspecialchars($product['name']);
                echo " - Qty: " . $quantity;
                echo " - RM " . number_format($subtotal, 2);
                echo "</p>";
                echo "</div>";
            }
        }

        echo "<h3>Total: RM " . number_format($total, 2) . "</h3>";

        echo '<button type="button">Proceed to Checkout</button>';
    }
    ?>

</body>
</html>