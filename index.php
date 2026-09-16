<?php
include "connect.php";
session_start();

$result = $conn->query("SELECT * FROM products ORDER BY productID");
$classes = ['c1', 'c2', 'c3'];
$i = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devimge-width, initial-scale=1.0">
    <title>test</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&imgon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatimg.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo"><a href="#">CUNA'S BAKERY</a></div>
        <ul class="links">
            <li><a href="#">HOME</a></li>
            <li><a href="#">ITEMS</a></li>
        </ul>
        <div class="btns">
            <a href="" class="order-now-btn">ORDER NOW</a>
            <a href="" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
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
                        <a href="" class="order-btn">ORDER NOW</a>
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
                                <img src="uploads/u good.jpg">
                            </div>
                            <div class="item-card-details">
                                <h3><?php echo htmlspecialchars($row['name']) ?></h3>
                                <p><?php echo htmlspecialchars($row['description']) ?></p>
                                <p>RM <?php echo htmlspecialchars($row['price']) ?></p>
                            </div>
                            <div class="item-card-button">
                                <button class="item-details <?= $classes[$i] ?>" popovertarget="pd <?= $classes[$i] ?>">DETAILS</button>
                                <dialog id="pd <?= $classes[$i] ?>" popover>
                                    <p><?= htmlspecialchars($row['description']) ?></p>
                                </dialog>
                                <button><a href='cart.php?table=products&id=".$row["ID"]."'><span class="material-symbols-outlined">shopping_cart</span></a></button>
                            </div>
                        </div>
                    <?php $i++;
                    } ?>
                </div>
                <h6><a href="">VIEW ALL</a></h6>
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
                <span> <i class="fab fa-whatsapp"></i> 012-3456789</span>
            </div>
        </div>
    </footer>
</body>

</html>
