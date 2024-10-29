<?php
session_start();
include 'db_connect.php';

// Fetch the details you want to include in the report
$application_id = $_GET['application_id'];

// Fetch application and student details
try {
    $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status, s.country
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Latihan Industri(Undang-Undang)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }
        .gov-logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px; 
            height: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <br>
    <img src="images/gov.png" alt="Government Logo" class="gov-logo">
    <h1 style="text-align: center;">PEJABAT KETUA PENDAFTAR MAHKAMAH PERSEKUTUAN MALAYSIA</h1>

    <br>

    <?php if (!empty($application_details)) : ?>
        <h2><u>Laporan Permohonan</u></h2>
        <p><strong>Permohonan ID:</strong> <?php echo htmlspecialchars($application_details[0]['application_id']); ?></p>
        <p><strong>Borang Sokongan:</strong> <?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?></p>
        <p><strong>Tarikh Mula:</strong> <?php echo htmlspecialchars($application_details[0]['start_date']); ?></p>
        <p><strong>Tarikh Tamat:</strong> <?php echo htmlspecialchars($application_details[0]['end_date']); ?></p>

        <h2>Butiran Pelajar</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Pelajar</th>
                    <th>No. Matriks</th>
                    <th>No Pengenalan Diri</th>
                    <th>Kursus/Program</th>
                    <th>Negeri</th>
                    <th>Lokasi Mahkamah</th>
                    <th>Negara</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($application_details as $detail) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($detail['student_matrics']); ?></td>
                        <td><?php echo htmlspecialchars($detail['student_ic']); ?></td>
                        <td><?php echo htmlspecialchars($detail['kursus']); ?></td>
                        <td><?php echo htmlspecialchars($detail['negeri']); ?></td>
                        <td><?php echo htmlspecialchars($detail['lokasi']); ?></td>
                        <td><?php echo htmlspecialchars($detail['country']); ?></td>
                        <td><?php echo htmlspecialchars($detail['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No details found for the selected application ID.</p>
    <?php endif; ?>

    <!-- Form to generate and download the PDF -->
    <form method="post" action="export_pdf.php" target="_blank">
        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application_id); ?>">
        <button type="submit" class="btn btn-success">Eksport ke PDF</button>
    </form>
    <!-- Form to export to Excel -->
    <form method="post" action="export_excel.php" target="_blank">
        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($application_id); ?>">
        <button type="submit" class="btn btn-primary no-print">Eksport ke Excel</button>
    </form>
    <br>
    <form method="post" action="display.php" target="_blank">
        <button type="submit" class="btn btn-success">Home</button>
    </form>
</div>

</body>
</html>
