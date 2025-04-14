<?php
// File: add_product.php
require 'session.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileSize = $_FILES['image']['size'];
        $fileType = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (in_array($fileType, $allowedTypes) && $fileSize <= 2 * 1024 * 1024) {
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . uniqid() . '_' . $fileName;
            move_uploaded_file($fileTmpPath, $filePath);
            $image_path = $filePath;
        } else {
            $error = 'Invalid file type or size exceeds 2MB.';
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare('INSERT INTO products (user_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $name, $description, $price, $image_path]);
        header('Location: dashboard.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Add Product</title>
</head>
<body>
<div class="container">
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="file" name="image" accept="image/jpeg,image/png">
        <button type="submit">Add Product</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>