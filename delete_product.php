<?php
// File: delete_product.php
require 'session.php';
require 'db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT image_path FROM products WHERE id = ? AND user_id = ?');
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $product = $stmt->fetch();

    if ($product) {
        if ($product['image_path'] && file_exists($product['image_path'])) {
            unlink($product['image_path']);
        }
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ? AND user_id = ?');
        $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    }
}
header('Location: dashboard.php');
exit();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Delete Product</title>
</head>
<body>
<div class="container">
    <h2>Delete Product</h2>
    <p>Are you sure you want to delete this product?</p>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <button type="submit" name="confirm" value="yes">Yes, Delete</button>
        <a href="dashboard.php">Cancel</a>
    </form>
</div>
</body>
</html>