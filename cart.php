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
        }
        else {
            // Product quantity doesn't exist
            $quantity = 1;

            $stmt = $conn->prepare("INSERT INTO cart (userID, productID, quantity)
                                   VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $userID, $productID, $quantity);
            $stmt->execute();
        }
        header("Location: cart.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Shopping Cart</title>
</head>

<body>

    <h2>Your Cart</h2>

    <?php
        $stmt = $conn->prepare("SELECT cart.productID, cart.quantity, products.name, products.price 
                                FROM cart
                                INNER JOIN products
                                    ON cart.productID = products.productID
                                WHERE cart.userID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();

        $result = $stmt->get_result();

        $total = 0;

        while ($product  = $result->fetch_assoc()) {
            $subtotal = $product['price'] * $product['quantity'];

            $total += $subtotal;

            echo "<div>";

            echo "<p>";
            echo htmlspecialchars($product['name']);
            echo " - Qty: " . $product['quantity'];
            echo " - RM " . number_format($subtotal, 2);
            echo "</p>";

            echo "</div>";
        }
        echo "<h3>Total: RM " . number_format($total, 2) . "</h3>";
        
        echo '<a href="index.php">Continue Shopping</a><br><br>';

        echo '<button type="button">Proceed to Checkout</button>';
    ?>

</body>
</html>