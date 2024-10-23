<?php
    include 'db_connect.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);
        $college_uni = trim($_POST['college_uni']);
        $no_phone = trim($_POST['no_phone']);
        $nama_pegawai = trim($_POST['nama_pegawai']); // New field

        // Automatically status = approved
        $status = "approved";

        if (empty($password) || empty($email) || empty($college_uni) || empty($no_phone) || empty($nama_pegawai))
        {
            echo '<script>alert("All fields are required.");</script>';
            echo '<script>window.location.href = "signup.php";</script>';
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new institute into the database
        try
        {
            $stmt = $pdo->prepare("INSERT INTO users (password, email, college_uni, no_phone, nama_pegawai, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$hashed_password, $email, $college_uni, $no_phone, $nama_pegawai, $status]);

            header("Location: manage_users.php");
            exit();
        }
        catch (PDOException $e)
        {
            die('Database error: ' . $e->getMessage());
        }
    }
?>
