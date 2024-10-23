<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connect.php';

        $college = $_POST['college'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        $sql = "INSERT INTO penyelaras (college, name, phone, email) VALUES  (:college, :name, :phone, :email)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':college', $college);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            header("Location: liststudent.php");
            exit();
        } else {
            echo "Error: Unable to execute the SQL statement.";
        }
    } else {
        header("Location: borang_penyelaras.php");
        exit();
    }
?>



?>
