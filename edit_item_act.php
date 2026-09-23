<?php
include 'connect.php';
include 'session_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $productID = $_POST['productID'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = 'uploads/';
        $uploadFilePath = $uploadDir . $imageName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($imageTmpPath, $uploadFilePath)) {
            // Update the product with the new image path
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=? WHERE productID=?");
            $stmt->bind_param("ssdsi", $name, $description, $price, $uploadFilePath, $productID);
        } else {
            echo "<script>alert('Error uploading image.');
                    window.location='edit_item.php?productID=$productID';
                    </script>";
            exit();
        }
    } else {
        // Update the product without changing the image
        $sql = "UPDATE products SET name=?, description=?, price=? WHERE productID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $name, $description, $price, $productID);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Item successfully updated.');
                window.location='admin.php';
                </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>