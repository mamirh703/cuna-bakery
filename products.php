<?php
include "connect.php";
session_start();

$result = $conn->query("SELECT * FROM products ORDER BY productID");
$classes = ['c1', 'c2', 'c3', 'c4'];
$i = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Items</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            background-color: #F4EBE7;
        }

        /* Navbar */

        nav {
            width: 100%;
            padding: 1rem 5%;
            background: rgba(255, 255, 255, 0.5);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(15px);

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo a {
            list-style: none;
            text-decoration: none;
            font-family: chewy;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #331813;
        }

        /* nav links */

        .links {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .links li a {
            text-decoration: none;
            display: block;
            padding: 8px 0;
            height: 100%;
            font-size: 1.06rem;
            font-weight: 500;
            color: black;
        }

        /* nav buttons */

        .btns {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btns a {
            color: black;
            text-decoration: none;
        }

        .order-now-btn {
            padding: 5px 10px;
            border: 1px solid black;
            background-color: bisque;
        }

        .cart-btn {
            padding: 5px 10px 3px 12px;
            background-color: lightgray;
            border: 1px solid black;
        }

        /* Main Content */

        .item-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, 370px);
            margin-top: 3rem;
            gap: 3rem;
            align-items: center;
            justify-content: center;
        }

        .item-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #FFF7EA;
            padding-bottom: 2rem;
            border-radius: 100px;
            corner-shape: scoop squircle square square;
        }

        .item-card-img {
            height: 200px;
        }

        .item-card-img img {
            width: 100%;
            height: 100%;
        }

        .item-card-details {
            justify-items: center;
            align-items: center;
        }

        .item-card-button {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }

        [popover] {
            position: fixed;
            inset: 0;
            margin: auto;
            width: min(320px, 90vw);
            border: none;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .2);
            transition: all 0.3s ease;
        }

        [popover]::backdrop {
            background: rgba(0, 0, 0, .08);
            backdrop-filter: blur(2px);
        }

        /* Footer */

        footer {
            margin-top: 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2.5rem 5%;
            background: rgba(255, 255, 255, 0.5);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(15px);
        }

        .brand-footer {
            font-family: chewy;
            font-size: 3rem;
            font-weight: 700;
            color: #331813;
        }

        .footer-kanan p {
            font-size: 1.8rem;
            font-weight: 600;
        }

        .footer-kanan-span {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo"><a href="#">CUNA'S BAKERY</a></div>
        <ul class="links">
            <li><a href="index.php">HOME</a></li>
            <li><a href="products.php">ITEMS</a></li>
        </ul>
            <div class="btns">
                <a href="products.php" class="order-now-btn">ORDER NOW</a>
            <a href="cart.php" class="cart-btn"><span class="material-symbols-outlined">shopping_cart</span></a>
        </div>
    </nav>
    <!-- Main Content -->
    <main>
        <div class="item-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
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
                        <form method="POST" action="cart.php" style="display:inline;">
                            <input type="hidden" name="productID" value="<?= (int)$row['productID'] ?>">
                            <button type="submit" name="add_to_cart">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php $i++;
            } ?>
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