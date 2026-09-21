```php
<?php

include "connect.php";
include "session_check.php";

if (isset($_POST["update"])) {

    $table = $_POST["table"];
    $id = $_POST["id"];

    // Get the old image
    $oldImage = $_POST["old_image"];

    // Store all fields that need to be updated
    $updates = [];

    foreach ($_POST as $column => $value) {

        // Don't update these fields
        if (
            $column == "update" ||
            $column == "table" ||
            $column == "id" ||
            $column == "old_image"
        ) {
            continue;
        }

        // Don't update productID
        if ($column == "productID") {
            continue;
        }

        $updates[$column] = $value;
    }

    /*
     * IMAGE
     */

    if (!empty($_FILES["image"]["name"])) {

        // New image was selected
        $imageName = $_FILES["image"]["name"];
        $tmpName = $_FILES["image"]["tmp_name"];

        // Generate a unique filename
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $newImageName = uniqid() . "." . $extension;

        // Upload location
        $uploadPath = "uploads/" . $newImageName;

        if (move_uploaded_file($tmpName, $uploadPath)) {

            // Add new image to update
            $updates["image"] = $newImageName;

            // Delete old image
            if (
                !empty($oldImage) &&
                file_exists("uploads/" . $oldImage)
            ) {
                unlink("uploads/" . $oldImage);
            }

        } else {

            // Upload failed → keep old image
            $updates["image"] = $oldImage;
        }

    } else {

        // No new image → KEEP OLD IMAGE
        $updates["image"] = $oldImage;
    }


    /*
     * BUILD UPDATE QUERY
     */

    $setParts = [];

    foreach ($updates as $column => $value) {

        $setParts[] = "`$column` = ?";
    }

    $sql = "UPDATE `$table`
            SET " . implode(", ", $setParts) . "
            WHERE productID = ?";


    /*
     * PREPARED STATEMENT
     */

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }


    /*
     * BIND VALUES
     */

    $types = "";
    $values = [];

    foreach ($updates as $value) {

        $types .= "s";
        $values[] = $value;
    }

    // productID
    $types .= "i";
    $values[] = $id;


    $stmt->bind_param(
        $types,
        ...$values
    );


    /*
     * EXECUTE
     */

    if ($stmt->execute()) {

        echo "<script>
                alert('Item updated successfully!');
                window.location.href = 'admin_add.php';
            </script>";

    } else {

        echo "Error updating item: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>
```
