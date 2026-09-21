<?php
include "connect.php";
include "session_check.php";

$result = $conn->query("SELECT * FROM products WHERE is_active = 1 ORDER BY productID");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CUNA'S BAKERY</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo"><a href="admin.php">CUNA'S BAKERY</a></div>
        <ul class="links">
            <li><a href="admin.php">HOME</a></li>
            <li><a href="admin_add.php">ITEMS</a></li>
            <li><a href="admin_orders.php">VIEW ORDERS</a></li>
            <li><a href="mng_user.php">USERS</a></li>
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
                    <!-- childe -->
                    <div class="item-card-img">
                        <!-- delete button relative to image -->
                        <a href="del_item.php?productID=<?= $row['productID'] ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="black" style="position: absolute; top: 30; right: 30px;">
                                <path d="M280-440h400v-80H280v80ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg></a>
                        <!-- gambar -->
                        <img src="<?= htmlspecialchars($row['image']) ?>">
                    </div>
                    <div class="item-card-details">
                        <h3><?php echo htmlspecialchars($row['name']) ?></h3>
                        <p><?php echo htmlspecialchars($row['description']) ?></p>
                        <p>RM <?php echo htmlspecialchars($row['price']) ?></p>
                    </div>
                    <div class="item-card-button">
                        <button class="item-details <?= $row['productID'] ?>" popovertarget="pd<?= $row['productID'] ?>">DETAILS</button>
                        <dialog id="pd<?= $row['productID'] ?>" popover>
                            <img src="<?= htmlspecialchars($row['image']) ?>">
                            <p><?= htmlspecialchars($row['description']) ?></p>
                        </dialog>
                        <?php
                        echo "<a href='edit_item.php?table=products&id=".$row["productID"]."'><button class='edit'><span class='material-symbols-outlined'>edit</span></button></a>"
                        ?>
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