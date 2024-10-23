<?php
    require('fpdf/fpdf.php');

    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 10, 'APPLICATION REPORT');  // Title in uppercase
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);

        // Fetch application details to display in PDF
        $stmt = $pdo->prepare("SELECT ia.application_id, ia.start_date, ia.end_date, s.student_name, s.student_matrics, s.student_ic, s.kursus, s.status
                                FROM internship_applications ia
                                INNER JOIN students s ON ia.application_id = s.application_id");
        $stmt->execute();
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($applications as $app) {
            $pdf->Cell(40, 10, 'ID: ' . strtoupper($app['application_id']));  // ID in uppercase
            $pdf->Ln();
            // Convert student name to uppercase using strtoupper
            $pdf->Cell(40, 10, 'STUDENT NAME: ' . strtoupper($app['student_name']));  // Name in uppercase
            $pdf->Ln();
            // Convert status to uppercase using strtoupper
            $pdf->Cell(40, 10, 'STATUS: ' . strtoupper($app['status']));  // Status in uppercase
            $pdf->Ln();
            $pdf->Ln();
        }

        $pdf->Output('D', 'report.pdf'); // Force download the PDF
    }
?>
