<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    if ($admin_username === 'admin' && $admin_password === 'password') { 
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="admin_username">Username:</label>
        <input type="text" id="admin_username" name="admin_username" required>
        <br>
        <label for="admin_password">Password:</label>
        <input type="password" id="admin_password" name="admin_password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
