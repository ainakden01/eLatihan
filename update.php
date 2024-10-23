<?php
session_start();
include 'db_connect.php'; // Include your database connection file

// Check if user session exists and get user_id
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if session does not exist
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch application ID from the URL
if (!isset($_GET['id'])) {
    // Redirect to display.php if no ID is provided
    header("Location: display.php");
    exit();
}

$application_id = $_GET['id'];

// Fetch application details from the database
$sql = "SELECT ia.application_id, ia.student_name, ia.student_matrics, ia.student_ic, ia.start_date, ia.end_date, 
               ia.borang_sokongan, n.id_negeri AS state_id, l.id_lokasi AS location_id
        FROM internship_applications ia
        INNER JOIN tblnegeri n ON ia.negeri_id = n.id_negeri
        INNER JOIN tbllokasi l ON ia.lokasi_id = l.id_lokasi
        WHERE ia.user_id = :user_id AND ia.application_id = :application_id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':application_id', $application_id);
$stmt->execute();
$application = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$application) {
    // Redirect to display.php if no application is found
    header("Location: display.php");
    exit();
}

// Handle form submission to update application details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $student_name = $_POST['student_name'];
    $student_matrics = $_POST['student_matrics'];
    $student_ic = $_POST['student_ic'];
    $state_id = $_POST['state_id'];
    $location_id = $_POST['location_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update SQL statement
    $updateSql = "UPDATE internship_applications 
                  SET student_name = :student_name, 
                      student_matrics = :student_matrics, 
                      student_ic = :student_ic, 
                      negeri_id = :state_id, 
                      lokasi_id = :location_id, 
                      start_date = :start_date, 
                      end_date = :end_date 
                  WHERE application_id = :application_id AND user_id = :user_id";

    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(':student_name', $student_name);
    $updateStmt->bindParam(':student_matrics', $student_matrics);
    $updateStmt->bindParam(':student_ic', $student_ic);
    $updateStmt->bindParam(':state_id', $state_id);
    $updateStmt->bindParam(':location_id', $location_id);
    $updateStmt->bindParam(':start_date', $start_date);
    $updateStmt->bindParam(':end_date', $end_date);
    $updateStmt->bindParam(':application_id', $application_id);
    $updateStmt->bindParam(':user_id', $user_id);

    // Execute the update statement
    if ($updateStmt->execute()) {
        // Redirect to detail.php with updated application ID
        header("Location: detail.php?id=" . $application_id);
        exit();
    } else {
        $error_message = "Failed to update application. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>e-Latihan Industri - Update Application Details</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100%; /* Ensures the background covers the entire viewport height */
        }
        .container1 {
            width: 100%;
            max-width: 100%;
            margin: 20px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            margin-top: 0;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .btn-back {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
        .btn-update {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        .btn-update:hover {
            background-color: #218838;
        }
    </style>
</head>
<body class="main-layout">
<!-- loader  -->
<div class="loader_bg">
    <div class="loader"><img src="images/loading.gif" alt="#"/></div>
</div>
<!-- end loader -->
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
                                <a class="nav-link" href="display.php">Semak Aplikasi</a>
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
<!-- end header inner -->
<!-- top -->
<div class="backg">
    <div class="full_bg">
        <div class="slider_main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container1">
                            <h2><b>Kemaskini Maklumat Permohonan</b></h2><br>
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $application_id); ?>" method="POST">
                                <div class="form-container">
                                    <div class="form-group">
                                        <label for="student_name">Nama Pelajar:</label>
                                        <input type="text" id="student_name" name="student_name" class="form-control" value="<?php echo htmlspecialchars($application['student_name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="student_matrics">No. Matriks:</label>
                                        <input type="text" id="student_matrics" name="student_matrics" class="form-control" value="<?php echo htmlspecialchars($application['student_matrics']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="student_ic">No. Kad Pengenalan:</label>
                                        <input type="text" id="student_ic" name="student_ic" class="form-control" maxlength="12" value="<?php echo htmlspecialchars($application['student_ic']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_id">Negeri:</label>
                                        <select id="state_id" name="state_id" class="form-control" required>
                                            <option value="">Pilih Negeri</option>
                                            <?php
                                            // Fetch states from database
                                            $sqlStates = "SELECT * FROM tblnegeri ORDER BY negeri ASC";
                                            $stmtStates = $pdo->query($sqlStates);
                                            while ($row = $stmtStates->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($row['id_negeri'] == $application['state_id']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_negeri']) . "' $selected>" . htmlspecialchars($row['negeri']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="location_id">Lokasi Mahkamah:</label>
                                        <select id="location_id" name="location_id" class="form-control" required>
                                            <option value="">Pilih Lokasi</option>
                                            <?php
                                            // Fetch locations from database
                                            $sqlLocations = "SELECT * FROM tbllokasi ORDER BY lokasi ASC";
                                            $stmtLocations = $pdo->query($sqlLocations);
                                            while ($row = $stmtLocations->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($row['id_lokasi'] == $application['location_id']) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($row['id_lokasi']) . "' $selected>" . htmlspecialchars($row['lokasi']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Tarikh Mula:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($application['start_date']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">Tarikh Tamat:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($application['end_date']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-update">Kemaskini</button>
                                        <a href="detail.php?id=<?php echo htmlspecialchars($application['application_id']); ?>" class="btn btn-secondary btn-back">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end top -->
<!-- end header -->
<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<!-- sidebar -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
