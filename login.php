<?php
// File: login.php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!-- HTML Form for login.php -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
</div>
</body>
</html>
