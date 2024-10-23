<?php
require('fpdf/fpdf.php'); 
session_start();
include 'db_connect.php';

$application_id = $_POST['application_id'] ?? null;

if (!$application_id) {
    die("Invalid request: application ID is missing.");
}

try {
    $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, 
                                  s.student_name, s.student_matrics, s.student_ic, s.kursus, 
                                  n.negeri, l.lokasi, s.status
                           FROM internship_applications ia
                           INNER JOIN students s ON ia.application_id = s.application_id
                           INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                           INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                           WHERE ia.application_id = :application_id");
    $stmt->bindParam(':application_id', $application_id);
    $stmt->execute();
    $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if (!empty($application_details)) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $logo_width = 30;
    $x = ($pdf->GetPageWidth() - $logo_width) / 2;  

    $pdf->Image('images/gov.png', $x, 10, 30, 30);  

    $pdf->Ln(30);  
    $pdf->Cell(0, 10, 'PEJABAT KETUA PENDAFTAR MAHKAMAH PERSEKUTUAN MALAYSIA', 0, 1, 'C');
    $pdf->SetFont('Arial', 'U', 12); 
    $pdf->Cell(0, 10, 'LAPORAN PERMOHONAN', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Application ID:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $application_details[0]['application_id']);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Borang Sokongan:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $application_details[0]['borang_sokongan']);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Tarikh Mula:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $application_details[0]['start_date']);
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Tarikh Tamat:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $application_details[0]['end_date']);
    $pdf->Ln(20);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Nama Pelajar', 1);
    $pdf->Cell(30, 10, 'No. Matriks', 1);
    $pdf->Cell(30, 10, 'No Pengenalan Diri', 1);
    $pdf->Cell(40, 10, 'Kursus', 1);
    $pdf->Cell(50, 10, 'Lokasi Mahkamah', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($application_details as $detail) {
        $pdf->Cell(40, 10, $detail['student_name'], 1);
        $pdf->Cell(30, 10, $detail['student_matrics'], 1);
        $pdf->Cell(30, 10, $detail['student_ic'], 1);
        $pdf->Cell(40, 10, $detail['kursus'], 1);
        $pdf->Cell(50, 10, $detail['lokasi'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'Laporan_Permohonan_' . $application_id . '.pdf');
} else {
    echo "No details found for the selected application ID.";
}
?>
