<?php
include 'db_connect.php';

$admin_email = 'admin@admin';
$admin_password = '123123';
$admin_password_hash = password_hash($admin_password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (username, password_hash) VALUES (:username, :password_hash)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':username', $admin_email);
$stmt->bindParam(':password_hash', $admin_password_hash);
$stmt->execute();

echo "Admin user created successfully.";
?>
