<?php
// File: dashboard.php
require 'session.php';
require 'db.php';

$stmt = $pdo->prepare('SELECT * FROM products WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <h2>Your Products</h2>
    <div class="actions">
        <a href="add_product.php">Add New Product</a>
        <a href="logout.php">Logout</a>
    </div>
    <table>
    <tr><th>Image</th><th>Name</th><th>Description</th><th>Price</th><th>Action</th></tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><img src="<?= htmlspecialchars($product['image_path']) ?>" width="100"></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['description']) ?></td>
        <td>$<?= htmlspecialchars($product['price']) ?></td>
        <td><a href="delete_product.php?id=<?= $product['id'] ?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>
    </table>
</div>
</body>
</html>

