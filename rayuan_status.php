<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

// Get the application ID and student ID from the URL
$application_id = isset($_GET['application_id']) ? htmlspecialchars($_GET['application_id']) : '';
$student_id = isset($_GET['student_id']) ? htmlspecialchars($_GET['student_id']) : '';

if (empty($application_id)) {
    die('Application ID is missing.');
}

try {
    // Fetch appeal status and student details from the database
    $stmt = $pdo->prepare("
        SELECT rayuan.appeal_status, rayuan.remarks, rayuan.id_lokasi, students.student_name, students.student_matrics
        FROM rayuan
        JOIN students ON rayuan.student_id = students.student_id
        WHERE rayuan.application_id = ? AND rayuan.student_id = ?
    ");
    $stmt->execute([$application_id, $student_id]);
    $appeal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appeal) {
        die('No appeal information found for this Application ID and Student ID.');
    }

    // Fetch lokasi information
    $stmt = $pdo->prepare("SELECT lokasi FROM tbllokasi WHERE id_lokasi = ?");
    $stmt->execute([$appeal['id_lokasi']]);
    $lokasi = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Database query failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
        .btn-appeal {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-appeal:hover {
            background-color: #0056b3;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .status-failed {
            font-size: 24px;
            color: red;
            font-weight: bold;
            animation: blink 3.5s infinite;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0; }
        }
        /* Modal Styling */
        #successModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            text-align: center;
        }
        .modal-content img {
            width: 50px;
            height: 50px;
        }
        .modal-content h2 {
            color: green;
        }
        .modal-content button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }
        .modal-content button:hover {
            background-color: #218838;
        }
        .status-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .status-header {
            margin-bottom: 20px;
        }
        .status-card {
            padding: 10px;
            border-radius: 3px;
            background-color: #f0f0f0;
            margin-bottom: 15px;
        }

        .status-label {
            font-weight: bold;
        }

        .status-value {
            font-size: 16px;
            padding: 8px;
            border-radius: 3px;
            color: #000;
        }

        .Dalam_Proses {
            background-color: yellow; 
        }

        .Lulus {
            background-color: green;
        }

        .Tidak_Lulus {
            background-color: red;
        }
        .btn-back {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        .slider_main {
            padding-top:5%;
            padding-bottom:5%;
        }
        h2 {
            margin-top: 0;
            font-size: 30px;
        }
    </style>
</head>
<body class="main-layout">

    <!-- header -->
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.php"><img src="images/gov.png" alt="#" style="width: 50%;" /></a>&emsp;
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
                    <nav class="navigation navbar navbar-expand-md navbar-dark">
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
                <div class="col-md-2 d_none">
                    <ul class="email text_align_right">
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- Content Section -->
    <div class="content-wrapper">
        <div class="full_bg">
            <div class="slider_main">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="status-container">
                                <h2 class="status-header"><b>Status Rayuan<b></h2>
                                <div class="status-card">
                                    <p class="status-label">Application ID:</p>
                                    <p class="status-value"><?php echo htmlspecialchars($application_id); ?></p>
                                </div>
                                <div class="status-card">
                                    <p class="status-label">Nama Pelajar:</p>
                                    <p class="status-value"><?php echo htmlspecialchars($appeal['student_name']); ?></p>
                                </div>
                                <div class="status-card">
                                    <p class="status-label">No. Matriks:</p>
                                    <p class="status-value"><?php echo htmlspecialchars($appeal['student_matrics']); ?></p>
                                </div>
                                <div class="status-card">
                                    <p class="status-label">Lokasi Rayuan:</p>
                                    <p class="status-value"><?php echo htmlspecialchars($lokasi['lokasi']); ?></p>
                                </div>
                                <div class="status-card">
                                    <p class="status-label">Status Rayuan:</p>
                                    <p class="status-value"><b><?php echo htmlspecialchars($appeal['appeal_status']); ?><b></p>
                                </div>
                                <div class="status-card">
                                    <p class="status-label">Catatan:</p>
                                    <p class="status-value"><?php echo htmlspecialchars($appeal['remarks']); ?></p>
                                </div>
                                <a href="search_rayuan.php" class="btn-back">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
