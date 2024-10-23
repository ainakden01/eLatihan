<?php
session_start();
include 'db_connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'admin@admin') {
        $sql = "SELECT * FROM admins WHERE username = :username";
    } else {
        $sql = "SELECT * FROM users WHERE email = :email";
    }

    $stmt = $pdo->prepare($sql);

    if ($email === 'admin@admin') {
        $stmt->bindParam(':username', $email);
    } else {
        $stmt->bindParam(':email', $email);
    }

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($email === 'admin@admin') {
            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['admin_id'] = $user['admin_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: admin_dashboard.php");
                exit();
            }
        } else {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['college_uni'] = $user['college_uni'];
                header("Location: index.php");
                exit();
            }
        }
    }

    // Redirect with error parameter
    header("Location: login.php?error=1");
    exit();
} else {
    echo "Invalid request.";
}
?>
