<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    $stmt = $pdo->query("SELECT DISTINCT application_id FROM internship_applications ORDER BY application_id ASC");
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE students SET status = :status WHERE student_id = :student_id");
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF'] . "?application_id=" . $selected_application_id);
        exit();
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
    <title>e-Latihan Industri</title>
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
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        .status-pending {
            background-color: #fffacd; 
            font-weight: bold;
        }

        .status-approved {
            background-color: #c4ffc4; 
            font-weight: bold;
        }

        .status-disapproved {
            background-color: #ffcccb; 
            font-weight: bold;
        }
    </style>
</head>
<body class="main-layout">
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.html"><img src="images/gov.png" alt="index.php" style="width: 50%;" /></a>&emsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <i class="fas fa-user"></i>
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<span> Hi, " . htmlspecialchars($_SESSION['username']) . "</span>";
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
                                    <a class="nav-link" href="admin_dashboard.php">Home</a>
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
    <div class="full_bg">
        <div class="slider_main">
            <div class="container">
                <div class="row">
                    <div class="container1">
                        <h2><b>Display Application Details</b></h2><br>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <label for="application_id">Select Application ID:</label>
                                <select name="application_id" id="application_id" class="form-control">
                                    <option value="">Select Application ID</option>
                                    <?php foreach ($application_ids as $appid) : ?>
                                        <option value="<?php echo htmlspecialchars($appid); ?>" <?php if ($appid == $selected_application_id) echo "selected"; ?>><?php echo htmlspecialchars($appid); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" name="select_application" class="btn btn-primary">Semak Permohonan</button>    
                        </form>
                        <hr>
                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_application'])) : ?>
                            <?php if (!empty($application_details)) : ?>
                                <div class="form-row">
                                    <label for="borang_sokongan">Borang Sokongan:</label>
                                    <span><?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?></span>
                                    <span style="margin-left: 10px;"><a href="uploads/<?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?>" class="btn btn-primary" download>Download</a></span>
                                </div>
                                <div class="form-row">
                                    <label for="start_date">Tarikh Mula:</label>
                                    <span><?php echo htmlspecialchars($application_details[0]['start_date']); ?></span>
                                </div>
                                <div class="form-row">
                                    <label for="end_date">Tarikh Tamat:</label>
                                    <span><?php echo htmlspecialchars($application_details[0]['end_date']); ?></span>
                                </div>
                                
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Pelajar</th>
                                            <th>No.Matrics</th>
                                            <th>IC Pelajar</th>
                                            <th>Kursus/Program</th>
                                            <th>Negeri</th>
                                            <th>Lokasi Mahkamah</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <?php foreach ($application_details as $student) : ?>
                                                <?php 
                                                    // Determine the class based on status
                                                    $status_class = '';
                                                    if ($student['status'] == 'Sedang Diproses') {
                                                        $status_class = 'status-pending';
                                                    } elseif ($student['status'] == 'Lulus') {
                                                        $status_class = 'status-approved';
                                                    } elseif ($student['status'] == 'Tidak Lulus') {
                                                        $status_class = 'status-disapproved';
                                                    } else {
                                                        error_log("Unknown status: " . $student['status']);
                                                    }
                                                ?>
                                                <tr class="<?php echo $status_class; ?>">
                                                    <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['student_matrics']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['student_ic']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['kursus']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['negeri']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['lokasi']); ?></td>
                                                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                                                    <td>
                                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                            <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($selected_application_id); ?>">
                                                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">
                                                            <select name="status" class="form-control">
                                                                <option value="Sedang Diproses" <?php if ($student['status'] == 'Sedang Diproses') echo 'selected'; ?>>Sedang Diproses</option>
                                                                <option value="Lulus" <?php if ($student['status'] == 'Lulus') echo 'selected'; ?>>Lulus</option>
                                                                <option value="Tidak Lulus" <?php if ($student['status'] == 'Tidak Lulus') echo 'selected'; ?>>Tidak Lulus</option>
                                                            </select>
                                                            <button type="submit" name="update_status" class="btn btn-primary mt-2">Update</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                </table>
                            <?php else : ?>
                                <p>No application details found for the selected application ID.</p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
