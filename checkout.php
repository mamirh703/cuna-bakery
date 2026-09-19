<?php
    session_start();
    include 'connect.php';

    // Check login
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("Location: login.php");
        exit();
    }

    // Only members can checkout
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'member') {
        header("Location: login.php");
        exit();
    }

    // Get logged-in user's ID
    $userID = $_SESSION['userID'];

    $stmt = $conn->prepare("SELECT cart.productID, cart.quantity, products.name, products.price
                            FROM cart
                            INNER JOIN products
                                ON cart.productID = products.productID
                            WHERE cart.userID = ? ");

    $stmt->bind_param("i", $userID);
    $stmt->execute();

    $result = $stmt->get_result();

    $total = 0;

    while ($item = $result->fetch_assoc()) {

        $subtotal = $item['price'] * $item['quantity'];

        $total += $subtotal;
    }
?>

<h2>Checkout</h2>

<?php
echo "<p>Total: RM " . number_format($total, 2) . "</p>";
?>

<form action="payment.php" method="POST">
    <button type="submit" name="place_order">
        Proceed to Payment
    </button>
</form>