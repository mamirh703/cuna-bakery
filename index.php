<?php
    include "connect.php";
    session_start();

    $result = $conn->query("SELECT * FROM products ORDER BY productID");
    $classes=['c1','c2','c3'];
    $i=0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuna's Bakery</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart"/>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <nav>
            <a href="index.php"><h2>CUNA'S BAKERY</h2></a>
            <div class="directories">
                <span>
                <a href="index.php">HOME</a>
                </span>
                <span>
                    <a href="#">ITEMS</a>
                </span>
            </div>
            <div class="nav-btn">
                <div class="order-nav">
                    <button class="order-button">
                        <span class="order">ORDER NOW</span>
                    </button>
                </div>
                <div class="cart-nav">
                    <button class="cart-button"><span class="material-symbols-outlined">shopping_cart</span></button>
                </div>
            </div>
        </nav>
        <div class="hero">
            <svg viewbox="-67 -30 450 165">
                <polygon
                    points="-40,-20 -50,50 -40,125 360,125 370,50 360,-20"
                    fill="none"
                    stroke="black"
                    stroke-width="1"
                    stroke-linejoin="round"
                />
                <text x="90" y="5">
                    CUNA'S BAKERY
                </text>
            </svg>
            <p>
                Lorem ipsum dolor sit amet et delectus accommodare his consul copiosae legendos at vix ad putent delectus delicata usu. Vidit dissentiet eos cu eum
            </p>
            <div>
                <button class="order-main">
                        <a href="#">ORDER NOW</a>
                </button>
            </div>
            <div class="items-carousel">
                <div class="ic-cont">
                    <img src="uploads/DSC_0103.JPG">
                </div>
            </div>
        </div>
        <div class="subhero">
            <svg viewbox="-67 -30 450 215">
                <polygon
                    points="160,-15 -50,-5 -50,170 160,180 370,170 370,-5"
                    fill="none"
                    stroke="black"
                    stroke-width="1"
                />
                <text x="90" y="15">
                    POPULAR ITEMS
                </text>
            </svg>
            <div class="index-item-col">
                <?php
                while ($row = $result->fetch_assoc()) { ?>
                            <div class="index-item">
                                <div class="index-item-details">
                                    <h3><?php echo htmlspecialchars ($row['name'])?></h3>
                                    <p><?php echo htmlspecialchars ($row['description'])?></p>
                                    <p>RM <?php echo htmlspecialchars ($row['price'])?></p>
                                </div>
                                <div class="index-item-button">
                                    <button class="item-details <?= $classes[$i]?>" popovertarget="pd <?= $classes[$i]?>">DETAILS</button>
                                    <dialog id="pd <?= $classes[$i]?>" popover>
                                        <p><?= htmlspecialchars($row['description']) ?></p>
                                    </dialog>
                                    <a href='cart.php?table=products&id=".$row["ID"]."'><button><span class="material-symbols-outlined">shopping_cart</span></button></a>
                                </div>
                            </div>
                <?php $i++;} ?>
            </div>
        </div>
        <footer>
            <div class="brand-footer">
                <h1>CUNA'S BAKERY</h1>
            </div>
            <div class="footer-kanan">
                <h2>"SWEET AROMA COMES FROM HOMES"</h2>
                <div class="footer-kanan-span">
                    <span>cunasbakery</span>
                    <span>cunasbakery</span>
                    <span>012-3456789</span>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>