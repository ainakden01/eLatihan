<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $college_uni = $_POST['college_uni'];
    $email = $_POST['email'];
    $no_phone = $_POST['no_phone'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET college_uni = ?, email = ?, no_phone = ? WHERE user_id = ?");
        $stmt->execute([$college_uni, $email, $no_phone, $user_id]);
        header("Location: manage_users.php"); 
    } catch (PDOException $e) {
        die('Database query failed: ' . $e->getMessage());
    }
} else {
    header("Location: manage_users.php"); // Redirect if accessed without POST
}
?>
