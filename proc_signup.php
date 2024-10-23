<?php
    session_start(); // Start the session
    include 'db_connect.php'; 

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);
        $college_uni = trim($_POST['college_uni']);
        $no_phone = trim($_POST['no_phone']);
        $nama_pegawai = trim($_POST['nama_pegawai']); // New field

        if (empty($password) || empty($email) || empty($college_uni) || empty($no_phone) || empty($nama_pegawai))
        {
            echo '<script>alert("All fields are required.");</script>';
            echo '<script>window.location.href = "signup.php";</script>';
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO requests (password, email, college_uni, no_phone, nama_pegawai, status) 
                VALUES (:password, :email, :college_uni, :no_phone, :nama_pegawai, 'pending')";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':college_uni', $college_uni);
        $stmt->bindParam(':no_phone', $no_phone);
        $stmt->bindParam(':nama_pegawai', $nama_pegawai); // Bind new field

        if ($stmt->execute())
        {
            echo '<script>alert("Your request sent successfully. Waiting for admin approval.");</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit();
        }
        else
        {
            echo '<script>alert("Error: Unable to execute the SQL statement.");</script>';
        }
    }
    else
    {
        echo '<script>alert("Invalid request.");</script>';
        echo '<script>window.location.href = "signup.php";</script>';
    }
?>