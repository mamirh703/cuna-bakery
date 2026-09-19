<?php
include "connect.php";

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    $stmt = $conn->prepare("DELETE FROM products WHERE productID = ?");
    $stmt->bind_param("i", $productID);

    if ($stmt->execute()) {
        echo "<script>alert('Item deleted successfully.');
                window.location.href='admin.php';
                </script>";
        exit();
    } else {
        echo "Error deleting item.";
    }
}
?>