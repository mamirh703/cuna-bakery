<?php
include "connect.php";
include "session_check.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-item'])) {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = $_POST['price'] ?? '';

    $stmt = $conn->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $description, $price);
    $stmt->execute();

    echo "<script>alert('Item successfully added');
            window.location='admin.php';
            </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUNA'S BAKERY</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Add New Item</h1>
    </div>
    <div class="form-container">
        <form method="POST">
            <div class="add-form">
                <label for="name">Item Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($name ?? '') ?>">
                <br>
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?= htmlspecialchars($description ?? '') ?></textarea>
                <br>
                <label for="price">Price</label>
                <div class="price-bar">
                    <p class="currency">RM</p>
                    <input type="number" name="price" id="price" class="price-input" step="0.10" min="0" required value="<?= htmlspecialchars($price ?? '') ?>">
                </div>
            </div>
            <div class="down-btns">
                <a href="admin.php" class="cont-btn">← Back to Items List</a>
                <button type="submit" name="add-item" class="checkout-btn">ADD ITEM</button>
            </div>
        </form>
    </div>

</html>