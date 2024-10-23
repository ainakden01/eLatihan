<?php
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "intern";
    $port = "3307";

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $user_id = $_POST["user_id"];
        $action = $_POST["action"];

        if ($action == "approve")
        {
            // Get the user data from the requests table
            $query = "SELECT * FROM requests WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $user_data = $stmt->fetch();

            // Insert the user data into the users table
            $query = "INSERT INTO users (password, email, college_uni, no_phone, nama_pegawai, status) 
                      VALUES (:password, :email, :college_uni, :no_phone, :nama_pegawai, 'approved')";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':password', $user_data['password']);
            $stmt->bindParam(':email', $user_data['email']);
            $stmt->bindParam(':college_uni', $user_data['college_uni']);
            $stmt->bindParam(':no_phone', $user_data['no_phone']);
            $stmt->bindParam(':nama_pegawai', $user_data['nama_pegawai']);
            $stmt->execute();

            // Remove the user data from the requests table
            $query = "DELETE FROM requests WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            echo "success";
        }
        elseif ($action == "reject")
        {
            $query = "UPDATE requests SET status = 'rejected' WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            echo "success";
        }
    }
?>