<?php
    // Database connection
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

        if (isset($_GET['id_negeri']))
        {
            $idNegeri = $_GET['id_negeri'];
            $stmt = $pdo->prepare("SELECT id_lokasi, lokasi FROM tbllokasi WHERE id_negeri = ?");
            $stmt->execute([$idNegeri]);
            $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($locations);
        }
        
        else
        {
            echo json_encode([]);
        }
    }
    catch (PDOException $e)
    {
        die('Database connection failed: ' . $e->getMessage());
    }
?>
