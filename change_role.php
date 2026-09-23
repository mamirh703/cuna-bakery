<?php
session_start();
include 'connect.php';

// Admin-only auth
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update_role'])) {
    $userID = $_POST['userID'] ?? '';
    $newRole = $_POST['role'] ?? '';

    if ($userID !== '' && in_array($newRole, ['admin', 'member'], true)) {
        $stmt = $conn->prepare("UPDATE users SET role = ? WHERE userID = ?");
        $stmt->bind_param("si", $newRole, $userID);
        $stmt->execute();
    }

    header("Location: change_role.php?userID=" . urlencode($userID) . "&updated");
    exit();
}

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE userID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cuna's Bakery - Change Role</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="header">
            <h1>Change Role</h1>
        </div>
        <?php
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); ?>
        <div class="order-container">
            <a href="mng_user.php">← Back to Manage Users</a>
            <?php if (isset($_GET['updated'])): ?>
                <p><strong>✓ Role updated.</strong></p>
            <?php endif; ?>
            <h2>Order #<?= htmlspecialchars($user['userID']) ?></h2><br>
            <h3>Customer Info</h3>
            <div class="order-info">
                <div class="order-meta">
                    <p>Username: </p>
                    <p class="value"><?= htmlspecialchars($user['username']) ?></p>
                </div>
                <div class="order-meta">
                    <p>Current Role: </p>
                    <p class="value"><?= htmlspecialchars($user['role']) ?></p>
                </div>
            </div>
            <h2>Role</h2>
        </div>
        <div class="order-container">
            <form method="POST" action="change_role.php">
                <input type="hidden" name="userID" value="<?= htmlspecialchars($user['userID']) ?>">
                <div class="order-info">
                    <div class="order-meta">
                        <input type="hidden" name="userID" value="<?= htmlspecialchars($user['userID']) ?>">
                        <label>
                            <input type="radio" name="role" value="member"
                                <?= $user['role'] === 'member' ? 'checked' : '' ?>>
                            Member
                        </label>
                    </div>
                    <div class="order-meta">
                        <label>
                            <input type="radio" name="role" value="admin"
                                <?= $user['role'] === 'admin' ? 'checked' : '' ?>>
                            Admin
                        </label>
                    </div>
                    <div class="order-meta">
                        <button type="submit" class="checkout-btn" name="update_role">SAVE ROLE</button>
                    </div>
                </div>
            </form>
        <?php
    } ?>
        </div>
    </body>

    </html>