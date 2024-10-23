<?php
    $host = 'localhost';
    $dbname = 'intern';
    $username = 'root';
    $password = '';
    $port = '3307';

    try
    {
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die('Connection failed: ' . $e->getMessage());
    }
?>

