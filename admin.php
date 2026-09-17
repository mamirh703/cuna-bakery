<?php
include "connect.php";
include "session_check.php";

$result = $conn->query("SELECT * FROM products ORDER BY productID");
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
    <!-- Navbar -->
    <nav>
        <div class="logo"><a href="index.php">CUNA'S BAKERY</a></div>
        <ul class="links">
            <li><a href="index.php">HOME</a></li>
            <li><a href="items.php">ITEMS</a></li>
        </ul>
        <div class="btns">
            <a href="items.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
        </div>
    </nav>
    <main>
        <!-- Item Display -->
        <div class="item-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <!-- Parent -->
                <div class="item-card">
                    <!-- parent -->
                    <div class="item-card-img">
                        <img src="uploads/u good.jpg">
                    </div>
                    <div class="item-card-details">
                        <h3><?php echo htmlspecialchars($row['name']) ?></h3>
                        <p><?php echo htmlspecialchars($row['description']) ?></p>
                        <p>RM <?php echo htmlspecialchars($row['price']) ?></p>
                    </div>
                    <div class="item-card-button">
                        <button class="item-details <?= $row['productID'] ?>" popovertarget="pd <?= $row['productID'] ?>">DETAILS</button>
                        <dialog id="pd <?= $row['productID'] ?>" popover>
                            <img src="uploads/u good.jpg">
                            <p><?= htmlspecialchars($row['description']) ?></p>
                        </dialog>
                        <form method="POST" action="cart.php" style="display:inline;">
                            <input type="hidden" name="productID" value="<?= $row['productID'] ?>">
                            <button class="item-cart" type="submit" name="add_to_cart">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php
            } ?>
            <!-- Add Item Card -->
            <div class="add-item">
                <a href="add_item.php">
                    <svg xmlns="http://www.w3.org/2000/svg" height="100px" viewBox="0 -960 960 960" width="100px">
                        <path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                    </svg>
                </a>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer>
        <div class="brand-footer">
            <p>CUNA'S BAKERY</p>
        </div>
        <div class="footer-kanan">
            <p>"SWEET AROMA COMES FROM HOMES"</p>
            <div class="footer-kanan-span">
                <span><i class="fab fa-facebook-f"></i> cunasbakery </span>
                <span><i class="far fa-envelope"></i> cunasbakery</span>
                <span><i class="fab fa-whatsapp"></i> 012-3456789</span>
            </div>
        </div>
    </footer>
</body>

</html>
