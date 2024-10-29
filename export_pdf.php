<?php
require('fpdf/fpdf.php'); 
session_start();
include 'db_connect.php';

$application_id = $_POST['application_id'] ?? null;

if (!$application_id) {
    die("INVALID REQUEST: APPLICATION ID IS MISSING.");
}

try {
    $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, 
                                  s.student_name, s.student_matrics, s.student_ic, s.kursus, 
                                  n.negeri, l.lokasi, s.country, s.status
                           FROM internship_applications ia
                           INNER JOIN students s ON ia.application_id = s.application_id
                           INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                           INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                           WHERE ia.application_id = :application_id");
    $stmt->bindParam(':application_id', $application_id);
    $stmt->execute();
    $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('DATABASE CONNECTION FAILED: ' . $e->getMessage());
}

if (!empty($application_details)) {
    // Set page to landscape for more space
    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Set up the logo at the center
    $logo_width = 30;
    $x = ($pdf->GetPageWidth() - $logo_width) / 2;  
    $pdf->Image('images/gov.png', $x, 10, 30, 30);  

    $pdf->Ln(30);  
    $pdf->Cell(0, 10, 'PEJABAT KETUA PENDAFTAR MAHKAMAH PERSEKUTUAN MALAYSIA', 0, 1, 'C');
    $pdf->SetFont('Arial', 'U', 12); 
    $pdf->Cell(0, 10, 'LAPORAN PERMOHONAN', 0, 1, 'C');
    $pdf->Ln(10);

    // Application Details Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'APPLICATION ID:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, strtoupper($application_details[0]['application_id']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'BORANG SOKONGAN:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, strtoupper($application_details[0]['borang_sokongan']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'TARIKH MULA:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, strtoupper($application_details[0]['start_date']));
    $pdf->Ln();

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, 'TARIKH TAMAT:');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, strtoupper($application_details[0]['end_date']));
    $pdf->Ln(20);

    // Table Header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(35, 10, 'NAMA PELAJAR', 1);
    $pdf->Cell(35, 10, 'NO. MATRIKS', 1);
    $pdf->Cell(50, 10, 'NO PENGENALAN DIRI', 1);
    $pdf->Cell(35, 10, 'KURSUS', 1);
    $pdf->Cell(45, 10, 'LOKASI MAHKAMAH', 1);
    $pdf->Cell(30, 10, 'NEGARA', 1);
    $pdf->Ln();

    // Table Content
    $pdf->SetFont('Arial', '', 12);
    foreach ($application_details as $detail) {
        $pdf->Cell(35, 10, strtoupper($detail['student_name']), 1);
        $pdf->Cell(35, 10, strtoupper($detail['student_matrics']), 1);
        $pdf->Cell(50, 10, strtoupper($detail['student_ic']), 1);
        $pdf->Cell(35, 10, strtoupper($detail['kursus']), 1);
        $pdf->Cell(45, 10, strtoupper($detail['lokasi']), 1);
        $pdf->Cell(30, 10, strtoupper($detail['country']), 1);
        $pdf->Ln();
    }

    // Output the PDF
    $pdf->Output('D', 'LAPORAN_PERMOHONAN_' . strtoupper($application_id) . '.pdf');
} else {
    echo "NO DETAILS FOUND FOR THE SELECTED APPLICATION ID.";
}
?>
