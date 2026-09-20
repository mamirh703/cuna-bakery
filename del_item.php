<?php
session_start();
include "connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['productID'])) {
    $productID = (int)$_GET['productID'];

    // Soft delete — mark inactive
    $stmt = $conn->prepare("UPDATE products SET is_active = 0 WHERE productID = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();

    echo "<script>alert('Item removed from shop.');
            window.location.href='admin.php';
            </script>";
    exit();
}
