<?php
session_start();
include 'db_connect.php'; 
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Update application status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    $sql = "UPDATE internship_applications SET status = :status WHERE application_id = :application_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':application_id', $application_id);
    $stmt->execute();
}
?>
