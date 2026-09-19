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

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['checkout'])) {
    header("Location: cart.php");
    exit();
}

// Verify cart is not empty
$stmt = $conn->prepare("
    SELECT 
        SUM(products.price * cart.quantity) AS total
    FROM cart
    INNER JOIN products ON cart.productID = products.productID
    INNER JOIN users    ON users.userID   = cart.userID
    WHERE cart.userID = ?
    GROUP BY users.userID
");
$stmt->bind_param("i", $userID);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row || $row['total'] <= 0) {
    echo "<script>alert('Your Cart is EMPTY!!');
            window.location='cart.php';
            </script>";
    exit();
}

header("Location: payment.php");
exit();
