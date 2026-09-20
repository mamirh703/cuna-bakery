<?php
include "connect.php";
session_start();

// if logged in and user is admin, redirect to admin page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['role'] === 'admin') {
    header("Location: admin.php");
    exit;
}

$result = $conn->query("SELECT * FROM products WHERE is_active = 1 ORDER BY productID");
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
        </div>
    </nav>
    <main>
        <!-- Title and Search Bar -->
        <div class="header">
            <h1>ITEMS</h1>
            <div class="searchBar">
                <i class="fa fa-search search-icon"></i>
                <input type="search" id="searchBar" placeholder="Search" oninput="filterList()" class="search-input">
            </div>
        </div>
        <!-- Item Display -->
        <div class="item-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
            <!-- Child -->
            <div class="item-card">
                <div class="item-card-img">
                    <img src="<?= htmlspecialchars($row['image'])?>">
                </div>
                <div class="item-card-details">
                    <h3><?php echo htmlspecialchars($row['name']) ?></h3>
                    <p><?php echo htmlspecialchars($row['description']) ?></p>
                    <p>RM <?php echo htmlspecialchars($row['price']) ?></p>
                </div>
                <div class="item-card-button">
                    <button class="item-details <?= $row['productID'] ?>" popovertarget="pd<?= $row['productID'] ?>">DETAILS</button>
                    <dialog id="pd<?= $row['productID'] ?>" popover>
                        <img src="<?= htmlspecialchars($row['image'])?>">
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
            <?php } ?>
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
    
    <script>
        /* Search Function */
        function filterList() {
            /* Get the search input value (lowercase for case-insensitive matching) */
            const query = document.getElementById('searchBar').value.toLowerCase().trim();

            /* Get all item cards */
            const cards = document.querySelectorAll('.item-card');

            /* Loop through each card and show/hide based on match */
            cards.forEach(card => {
                /* Get the product name and description text */
                const name = card.querySelector('.item-card-details h3')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.item-card-details p')?.textContent.toLowerCase() || '';

                /* Check if query matches name or description */
                const matches = name.includes(query) || description.includes(query);

                /* Show or hide the card */
                card.style.display = matches ? '' : 'none';
            });
        }
    </script>
</body>
</html>
