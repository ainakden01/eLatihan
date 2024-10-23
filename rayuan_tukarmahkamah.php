<?php /*
session_start();
include 'db_connect.php';

if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

$student_id = isset($_GET['student_id']) ? htmlspecialchars($_GET['student_id']) : '';

$current_location = '';

if (empty($student_id)) {
    die('Student ID is missing.');
}

try {
    $stmt = $pdo->prepare("SELECT l.lokasi AS current_location
                           FROM internship_applications ia
                           INNER JOIN students s ON s.student_id = s.student_id
                           INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                           WHERE s.student_id = ?");
    $stmt->execute([$student_id]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($application) {
        $current_location = $application['current_location'];
    } else {
        die('No application information found for this ID.');
    }
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_location'])) {
    $new_location_id = htmlspecialchars($_POST['new_location']);

    try {
        $stmt = $pdo->prepare("UPDATE students s
                               INNER JOIN internship_applications ia ON s.student_id = ia.student_id
                               SET s.lokasi_id = ?
                               WHERE s.student_id = ?");
        $stmt->execute([$new_location_id, $student_id]);

        if ($stmt->rowCount() > 0) {
            $update_message = "Court location successfully updated!";
        } else {
            $update_message = "No update made. Check the student ID.";
        }
    } catch (PDOException $e) {
        die('Failed to update court location: ' . $e->getMessage());
    }
}*/

//********************************************* 7 DAYS **************************************** */
session_start();
include 'db_connect.php';

if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

$student_id = isset($_GET['student_id']) ? htmlspecialchars($_GET['student_id']) : '';

$current_location = '';

if (empty($student_id)) {
    die('Student ID is missing.');
}

// Retrieve internship start date
try {
    $stmt = $pdo->prepare("SELECT ia.start_date
                           FROM internship_applications ia
                           WHERE ia.student_id = ?");
    $stmt->execute([$student_id]);
    $internship_start_date = $stmt->fetchColumn();

    if (!$internship_start_date) {
        die('No internship start date found for this ID.');
    }
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Calculate the difference between today's date and internship start date
$today = date('Y-m-d');
$date_diff = strtotime($internship_start_date) - strtotime($today);
$days_before_internship = floor($date_diff / 86400); // Convert seconds to days

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_location'])) {
    if ($days_before_internship < 7) {
        die('Location change requests are only allowed 7 days or more before the internship start date.');
    }

    $new_location_id = htmlspecialchars($_POST['new_location']);

    try {
        $stmt = $pdo->prepare("UPDATE students s
                               INNER JOIN internship_applications ia ON s.student_id = ia.student_id
                               SET s.lokasi_id = ?
                               WHERE s.student_id = ?");
        $stmt->execute([$new_location_id, $student_id]);

        if ($stmt->rowCount() > 0) {
            $update_message = "Court location successfully updated!";
        } else {
            $update_message = "No update made. Check the student ID.";
        }
    } catch (PDOException $e) {
        die('Failed to update court location: ' . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
    <html lang="ms">
    <head>
        <meta charset="UTF-8">
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
            .btn-submit {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .btn-submit:hover {
                background-color: #0056b3;
            }
            .message {
                font-size: 18px;
                margin-bottom: 20px;
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
            h2 {
                margin-top: 0;
                font-size: 30px;
            }
        </style>
    </head>
    
    <body class="main-layout">
        <div class="loader_bg">
            <div class="loader"><img src="images/loading.gif" alt="#"/></div>
        </div>
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
        <div class="full_bg">
            <div class="slider_main">
                <div class="container">
                    <div class="row">
                        <div class="container1">
                            <h2><b>Rayuan Tukar Mahkamah</b></h2><br>
                            <div class="message">
                                <p><strong>Lokasi Mahkamah Semasa:</strong> <?php echo htmlspecialchars($current_location); ?></p>
                            </div>
                            <form action="rayuan_tukarmahkamah.php?student_id=<?php echo htmlspecialchars($student_id); ?>" method="post">
                                <div>
                                    <label for="new_location">Lokasi Baru:</label>
                                    <select id="new_location" name="new_location" required>
                                        <option value="">--Pilih Lokasi--</option>
                                        <?php
                                        try {
                                            $stmt = $pdo->prepare("SELECT id_lokasi, lokasi FROM tbllokasi");
                                            $stmt->execute();
                                            $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($locations as $location) {
                                                echo "<option value=\"" . htmlspecialchars($location['id_lokasi']) . "\">" . htmlspecialchars($location['lokasi']) . "</option>";
                                            }
                                        } catch (PDOException $e) {
                                            die('Failed to fetch location list: ' . $e->getMessage());
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn-submit">Hantar Rayuan</button>
                                </div>
                            </form>
                            <?php if (isset($update_message)): ?>
                                <div class="message"><?php echo htmlspecialchars($update_message); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>