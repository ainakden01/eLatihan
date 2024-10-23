<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

$student_id = isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : '';
$application_id = isset($_POST['application_id']) ? htmlspecialchars($_POST['application_id']) : '';
$id_lokasi = isset($_POST['id_lokasi']) ? $_POST['id_lokasi'] : ''; // Handle array separately
$remarks = isset($_POST['remarks']) ? htmlspecialchars($_POST['remarks']) : '';
$user_id = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : ''; // Added user_id

if (empty($student_id) || empty($application_id) || empty($id_lokasi) || empty($user_id)) {
    die('Required fields are missing.');
}

if (is_array($id_lokasi)) {
    $id_lokasi = implode(',', $id_lokasi); 
}

$appeal_status = 'Dalam Proses';

try {
    $stmt = $pdo->prepare("INSERT INTO rayuan (application_id, id_lokasi, appeal_status, remarks, student_id, user_id) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$application_id, $id_lokasi, $appeal_status, $remarks, $student_id, $user_id]);

    header("Location: rayuan_status.php?status=success&application_id=" . urlencode($application_id) . "&student_id=" . urlencode($student_id));
    exit();
} catch (PDOException $e) {
    die('Database query failed: ' . $e->getMessage());
}
?>
