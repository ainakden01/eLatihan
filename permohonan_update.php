<?php
include 'db_connect.php'; // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $application_id = $_POST['application_id'];
    $student_name = $_POST['student_name'];
    $student_matrics = $_POST['student_matrics'];
    $student_ic = $_POST['student_ic'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status']; 

    $sql = "UPDATE internship_applications 
            SET student_name = :student_name, 
                student_matrics = :student_matrics, 
                student_ic = :student_ic, 
                start_date = :start_date, 
                end_date = :end_date,
                status = :status 
            WHERE application_id = :application_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':student_matrics', $student_matrics);
    $stmt->bindParam(':student_ic', $student_ic);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':status', $status); 
    $stmt->bindParam(':application_id', $application_id);

    if ($stmt->execute()) {
    
        header("Location: display.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->errorInfo()[2];
    }
}
?>
