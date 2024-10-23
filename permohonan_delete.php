<?php
session_start();
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['appId'])) {
    $appId = $_GET['appId'];

    $sql = "DELETE FROM internship_applications WHERE application_id = :appId";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':appId', $appId);

    if ($stmt->execute()) {
        header("Location: display.php");
        exit();
    } else {
        echo "Error deleting record";
    }
}
?>
