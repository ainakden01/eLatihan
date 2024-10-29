<?php
session_start();
include 'db_connect.php';

$application_id = $_POST['application_id'] ?? null;

if (!$application_id) {
    die("Invalid request: application ID is missing.");
}

try {
    $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, 
                                  s.student_name, s.student_matrics, s.student_ic, s.kursus, 
                                  n.negeri, l.lokasi, s.country
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
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="application_report_' . $application_id . '.xls"');
    header('Cache-Control: max-age=0');

    echo "<html>";
    echo "<head><meta charset='UTF-8'></head>";
    echo "<body>";

    echo "<div style='text-align:center; margin-bottom:20px;'>";
    echo "<img src='images/gov.png' style='width:80px;' alt='Government Logo'><br>";
    echo "<h2>Pejabat Ketua Pendaftar Mahkamah Persekutuan Malaysia</h2>";
    echo "<h3>Laporan Permohonan</h3>";
    echo "</div>";

    echo "<table border='1' style='border-collapse:collapse; width:100%; margin-bottom:20px;'>";
    echo "<tr><th>Application ID</th><td>" . htmlspecialchars($application_details[0]['application_id']) . "</td></tr>";
    echo "<tr><th>Borang Sokongan</th><td>" . htmlspecialchars($application_details[0]['borang_sokongan']) . "</td></tr>";
    echo "<tr><th>Tarikh Mula</th><td>" . htmlspecialchars($application_details[0]['start_date']) . "</td></tr>";
    echo "<tr><th>Tarikh Tamat</th><td>" . htmlspecialchars($application_details[0]['end_date']) . "</td></tr>";
    echo "</table>";

    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<thead>";
    echo "<tr>
            <th>Nama Pelajar</th>
            <th>No. Matriks</th>
            <th>IC Pelajar</th>
            <th>Kursus</th>
            <th>Negeri</th>
            <th>Lokasi Mahkamah</th>
            <th>Negara</th>
          </tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($application_details as $detail) {
        echo "<tr>
                <td>" . htmlspecialchars($detail['student_name']) . "</td>
                <td>" . htmlspecialchars($detail['student_matrics']) . "</td>
                <td>" . htmlspecialchars($detail['student_ic']) . "</td>
                <td>" . htmlspecialchars($detail['kursus']) . "</td>
                <td>" . htmlspecialchars($detail['negeri']) . "</td>
                <td>" . htmlspecialchars($detail['lokasi']) . "</td>
                <td>" . htmlspecialchars($detail['country']) . "</td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";

    echo "</body>";
    echo "</html>";
} else {
    echo "No details found for the selected application ID.";
}
?>
