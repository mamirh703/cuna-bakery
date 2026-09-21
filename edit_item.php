<?php
include "connect.php";
include "session_check.php";

$table = $_GET["table"];
$id = $_GET["id"];

$sql = "SELECT * FROM $table WHERE productID = $id";
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

<div class="container">
    <div class="form-group">

        <form action="edit_item_act.php" method="POST" enctype="multipart/form-data">

            <!-- Important: pass the ID -->
            <input type="hidden" name="id"
                value="<?php echo htmlspecialchars($id); ?>">

            <!-- Pass table -->
            <input type="hidden" name="table"
                value="<?php echo htmlspecialchars($table); ?>">

            <?php

            $imageColumns = ["image"];

            foreach ($row as $column => $value) {

                if (in_array($column, $imageColumns)) {

                    echo "
                    <label>$column</label>

                    <!-- Keep the existing image filename -->
                    <input type='hidden'
                        name='old_$column'
                        value='" . htmlspecialchars($value) . "'>

                    <!-- Show existing image -->
                    <br>
                    <img src='uploads/" . htmlspecialchars($value) . "'
                        width='150'
                        alt='Current image'>

                    <br><br>

                    <!-- User can choose a new image -->
                    <input type='file'
                        class='form-control'
                        name='$column'
                        accept='image/*'>

                    <br>";

                } else {

                    // Don't allow productID to be changed
                    if ($column == "productID") {

                        echo "
                        <input type='hidden'
                            name='$column'
                            value='" . htmlspecialchars($value) . "'>";

                    } elseif ($column == "price") {
                        echo "
                        <label>$column</label>

                        <input type='number'
                            name='$column'
                            step='0.01'
                            min='0'
                            value='" . htmlspecialchars($value) . "'>";

                    } else {

                        echo "
                        <label>$column</label>

                        <input type='text'
                            class='form-control'
                            name='$column'
                            value='" . htmlspecialchars($value) . "'
                            required>

                        <br>";
                    }
                }
            }
            ?>

            <input type="submit" value="UPDATE" name="update">

        </form>

        <br>

    </div>
</div>

</body>
</html>