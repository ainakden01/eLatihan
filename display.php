<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
try {
    $stmt = $pdo->prepare("SELECT application_id FROM internship_applications WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $application_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

$selected_application_id = '';
$application_details = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_application'])) {
    $selected_application_id = $_POST['application_id'];

    try {
        $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status
                                FROM internship_applications ia
                                INNER JOIN students s ON ia.application_id = s.application_id
                                INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                                INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                                WHERE ia.application_id = :application_id");
        $stmt->bindParam(':application_id', $selected_application_id);
        $stmt->execute();
        $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Latihan Industri(Undang-Undang)</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <style>
        .container1 {
            width: 100%;
            max-width: 100%;
            padding: 50px;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .form-row label {
            width: 100px;
            margin-right: 10px;
        }
        .form-row input,
        .form-row select {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .btn-add,
        .btn-delete,
        .btn-logout,
        .btn-check {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-add:hover,
        .btn-check:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-logout {
            background-color: #dc3545;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        h2 {
            margin-top: 0;
            font-size: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        .status-pending {
            background-color: yellow;
            font-weight: bold;
        }
        .status-approved {
            background-color: green;
            font-weight: bold;
        }
        .status-disapproved {
            background-color: red;
            font-weight: bold;
        }
        .clickable-row {
            cursor: pointer;
        }
    </style>
</head>
<body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
    <!-- header -->
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.php"><img src="images/gov.png" alt="index.php" style="width: 50%;" /></a>&emsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <i class="fas fa-user"></i>
                    <?php
                    if (isset($_SESSION['college_uni'])) {
                        echo "<span> Hi, " . htmlspecialchars($_SESSION['college_uni']) . "</span>";
                    } else {
                        echo "<span>Welcome</span>";
                    }
                    ?>
                    <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="daftar1.php">Daftar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="display.php">Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="search_rayuan.php">Rayuan</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-2  d_none">
                    <ul class="email text_align_right">
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end header inner -->
<div class ="content-wrapper">
    <div class="full_bg">
        <div class="slider_main">
            <div class="container">
                <div class="row">
                    <div class="container1">
                        <h2><b>Senarai Permohonan e-Latihan Industri</b></h2><br>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="application_id">Pilih ID Permohonan:</label>
                                <select name="application_id" id="application_id" class="form-control">
                                    <option value="">Pilih ID Permohonan</option>
                                    <?php foreach ($application_ids as $appid) : ?>
                                        <option value="<?php echo htmlspecialchars($appid); ?>" <?php if ($appid == $selected_application_id) echo "selected"; ?>>
                                            <?php echo htmlspecialchars($appid); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="select_application" class="btn btn-primary">Semak Permohonan</button>
                        </form>
                        
                        <hr>
                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_application'])) : ?>
                            <?php if (!empty($application_details)) : ?>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="borang_sokongan"><b>Borang Sokongan:</b></label>
                                        <span><?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?></span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="start_date"><b>Tarikh Mula:</b></label>
                                        <span><?php echo htmlspecialchars($application_details[0]['start_date']); ?></span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="end_date"><b>Tarikh Tamat:</b></label>
                                        <span><?php echo htmlspecialchars($application_details[0]['end_date']); ?></span>
                                    </div>
                                    <form method="get" action="report.php" target="_blank">
                                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($selected_application_id); ?>">
                                        <button type="submit" class="btn btn-success">Cetak Laporan</button>
                                    </form>
                                </div>
                                <div class="table-responsive"> 
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th>Nama Pelajar</th>
                                                <th>No. Matriks</th>
                                                <th>No Pengenalan Diri</th>
                                                <th>Kursus/Program</th>
                                                <th>Negeri</th>
                                                <th>Lokasi Mahkamah</th>
                                                <th>Status</th>
                                                <th>Tindakan (Klik)</th> 
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
                                                    <td>
                                                        <?php
                                                        switch ($detail['status']) {
                                                            case 'Sedang diproses':
                                                                echo '<span style="color: yellow; font-weight: bold;">Sedang diproses</span>';
                                                                break;
                                                            case 'Lulus':
                                                                echo '<span style="color: green; font-weight: bold;">Lulus</span>';
                                                                break;
                                                            case 'Tidak Lulus':
                                                                echo '<span style="color: red; font-weight: bold;">Tidak Lulus</span>';
                                                                break;
                                                            default:
                                                                echo $detail['status'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        switch ($detail['status']) {
                                                            case 'Sedang Diproses':
                                                                echo '<a href="detail.php?student_id=' . htmlspecialchars($detail['student_id']) . '" class="clickable">';
                                                                echo '<i class="fas fa-edit" style="color: #000; cursor: pointer;"></i>';
                                                                echo '</a>';
                                                                break;
                                                            case 'Tidak Lulus':
                                                                echo '<a href="rayuan.php?student_id=' . htmlspecialchars($detail['student_id']) . '&application_id=' . htmlspecialchars($detail['application_id']) . '" class="clickable">';
                                                                echo '<i class="fas fa-exclamation-circle" style="color: #dc3545; cursor: pointer;"></i>';
                                                                echo '</a>';
                                                                break;
                                                            case 'Lulus':
                                                                echo '<a href="rayuan_tukarmahkamah.php?student_id=' . htmlspecialchars($detail['student_id']) . '" style="color: green;" class="clickable">Rayuan Tukar Mahkamah (Jika Perlu)</a>';
                                                                break;
                                                            default:
                                                                echo '<span>No Actions</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <p>Tiada butiran ditemui untuk ID aplikasi yang dipilih.</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const clickableElements = document.querySelectorAll(".clickable");
        clickableElements.forEach(element => {
            element.addEventListener("click", function(event) {
                // Prevent the default action if it's not needed
                event.preventDefault();

                const href = this.getAttribute("href");
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
    
</body>
</html>
