<?php
include "connect.php";
include "session_check.php";

$id = $_GET["productID"] ?? null;

$sql = "SELECT * FROM products WHERE productID = $id";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUNA'S BAKERY</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">
        <h1>Edit Item</h1>
    </div>
    <div class="form-container">
        <form action="edit_item_act.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="productID" value="<?= htmlspecialchars($row['productID']) ?>">
            <div class="add-form">
                <label for="name">Item Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($row['name']) ?>">
                <br>
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?= htmlspecialchars($row['description']) ?></textarea>
                <br>
                <!-- show current image -->
                <label for="current_image">Current Image</label>
                <img src="<?= htmlspecialchars($row['image']) ?>" alt="Current Image" style="width: 240px; height: 180px; object-fit: cover;">
                <br>
                <label for="price">Price</label>
                <div class="price-bar">
                    <p class="currency">RM</p>
                    <input type="number" name="price" id="price" class="price-input" step="0.01" min="0" required value="<?= htmlspecialchars($row['price']) ?>">
                </div>
                <br>
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
            </div>
            <div class="down-btns">
                <a href="admin_add.php" class="cont-btn">CANCEL</a>
                <button type="submit" name="update" class="checkout-btn">UPDATE</button>
            </div>
        </form>
    </div>

</body>

</html>