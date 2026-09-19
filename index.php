<?php
include "connect.php";
session_start();

$result = $conn->query("SELECT * FROM products ORDER BY productID LIMIT 3");
$classes = ['c1', 'c2', 'c3'];
$i = 0;
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
            <li><a href="orders.php">VIEW ORDERS</a></li>
        </ul>
        <div class="btns">
            <a href="items.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
            <a href="logout.php" class="order-now-btn">Logout</a>
        </div>
    </nav>
    <!-- Main Content -->
    <main>
        <div class="about">
            <!-- Background shape -->
            <div class="shape1">
                <h1>CUNA'S BAKERY</h1>
                <div class="para">
                    <p>
                        Lorem ipsum dolor sit amet et delectus accommodare his consul copiosae legendos at vix ad putent delectus delimgata usu. Vidit dissentiet eos cu eum
                    </p><br>
                    <div class="btns">
                        <a href="items.php" class="order-btn">ORDER NOW</a>
                    </div>
                </div>
            </div>
            <div class="img">
                <div class="img-cont">
                    <img src="uploads/DSC_0103.JPG">
                </div>
            </div>
        </div>
        <!-- Popular section -->
        <div class="popular">
            <!-- background shape 2 -->
            <div class="shape2">
                <h1>POPULAR ITEMS</h1>
                <!-- Parent -->
                <div class="item-grid">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <!-- Child -->
                        <div class="item-card">
                            <div class="item-card-img">
                                <img src="<?= htmlspecialchars($row['image']) ?>">
                            </div>
                            <div class="item-card-details">
                                <h3><?php echo htmlspecialchars($row['name']) ?></h3>
                                <p><?php echo htmlspecialchars($row['description']) ?></p>
                                <p>RM <?php echo htmlspecialchars($row['price']) ?></p>
                            </div>
                            <div class="item-card-button">
                                <button class="item-details <?= $classes[$i] ?>" popovertarget="pd <?= $classes[$i] ?>">DETAILS</button>
                                <dialog id="pd <?= $classes[$i] ?>" popover>
                                    <img src="<?= htmlspecialchars($row['image']) ?>">
                                    <p><?= htmlspecialchars($row['description']) ?></p>
                                </dialog>
                                <form method="POST" action="cart.php" style="display:inline;">
                                    <input type="hidden" name="productID" value="<?= $row['productID'] ?>">
                                    <button  class="item-cart" type="submit" name="add_to_cart">
                                    <span class="material-symbols-outlined">shopping_cart</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php $i++;
                    } ?>
                </div>
                <h6><a href="items.php">VIEW ALL</a></h6>
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
