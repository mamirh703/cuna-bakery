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

    // Get logged-in user
    $userID = $_SESSION['userID'];


    // Get user's cart
    $stmt = $conn->prepare("
        SELECT
            cart.productID,
            cart.quantity,
            products.price
        FROM cart
        INNER JOIN products
            ON cart.productID = products.productID
        WHERE cart.userID = ?
    ");

    $stmt->bind_param("i", $userID);
    $stmt->execute();

    $result = $stmt->get_result();


    // Calculate total
    $total = 0;
    $items = [];

    while ($item = $result->fetch_assoc()) {

        $subtotal = $item['price'] * $item['quantity'];

        $total += $subtotal;

        $items[] = $item;
    }


    // Don't create an empty order
    if (empty($items)) {
        echo "<script>
                alert('Your cart is empty! Please add a product before checkout.');
                window.location.href = 'cart.php';
            </script>";
        exit();
    }


    // Create order
    $stmt = $conn->prepare("INSERT INTO orders (userID, totalAmount, status)
                            VALUES (?, ?, 'Pending') ");
    $stmt->bind_param("id", $userID, $total);
    $stmt->execute();

    // Get new order ID
    $orderID = $conn->insert_id;

    // Insert order items
    foreach ($items as $item) {

        $stmt = $conn->prepare("INSERT INTO order_items (orderID, productID, quantity, price)
                                VALUES (?, ?, ?, ?) ");
        $stmt->bind_param("iiid", $orderID, $item['productID'], $item['quantity'], $item['price'] );

        $stmt->execute();
    }


    // Clear user's cart
    $stmt = $conn->prepare("DELETE FROM cart
                            WHERE userID = ? ");
    $stmt->bind_param("i", $userID);
    $stmt->execute();

    // Order successful
    header("Location: order_success.php?orderID=" . $orderID);
    exit();
?>