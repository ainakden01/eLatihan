<?php
session_start();
include 'db_connect.php'; 

// Check if admin session exists
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all colleges from the users table
try {
    $stmt = $pdo->query("SELECT DISTINCT college_uni FROM users ORDER BY college_uni ASC");
    $colleges = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Initialize variables
$selected_college = '';
$application_ids = [];
$selected_application_id = '';
$application_details = [];

// Fetch application IDs based on selected college
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_college'])) {
    $selected_college = $_POST['college_uni'];

    try {
        $stmt = $pdo->prepare("SELECT ia.application_id
                               FROM internship_applications ia
                               INNER JOIN users u ON ia.user_id = u.user_id
                               WHERE u.college_uni = :college_uni");
        $stmt->bindParam(':college_uni', $selected_college);
        $stmt->execute();
        $application_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }
}

// Fetch application details based on selected application ID
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

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['status'];
    $selected_college = $_POST['college_uni']; // Retain the selected college
    $selected_application_id = $_POST['application_id']; // Retain the selected application ID

    try {
        $stmt = $pdo->prepare("UPDATE students SET status = :status WHERE student_id = :student_id");
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        // Re-fetch the application details to display updated status
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
// Handle bulk status update to "Lulus"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_all'])) {
    $selected_college = $_POST['college_uni']; // Retain the selected college
    $selected_application_id = $_POST['application_id']; // Retain the selected application ID

    try {
        // Update all students' status to "Lulus"
        $stmt = $pdo->prepare("UPDATE students SET status = 'Lulus' WHERE application_id = :application_id");
        $stmt->bindParam(':application_id', $selected_application_id);
        $stmt->execute();

        // Re-fetch the application details to display updated status
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eLatihan Industri</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <style>
        body, html {
            overflow-x: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #FFBC00;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-sizing: border-box;
            color: #fff;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .logo img {
            width: 40%;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .header {
            height: 60px;
            background: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-left: 250px; 
            box-sizing: border-box;
        }

        .header .search {
            flex: 1;
            margin-left: 20px;
        }

        .header .search input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .user-info {
            display: flex;
            align-items: center;
        }

        .header .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
            box-sizing: border-box;
            max-width: calc(100% - 250px); 
            overflow-x: hidden; 
        }

        .main .cards {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .main .card {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .main .card h3 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .main .card p {
            font-size: 18px;
            margin: 0;
        }

        .main h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .main .table {
            margin-top: 20px;
            width: 100%; /* Ensure the table fits within the main content */
            overflow-x: auto; /* Enable horizontal scrolling for the table if needed */
        }

        .main .table thead th {
            background-color: #343a40;
            color: #fff;
        }

        .stats-box {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stats-box .stats-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 200px;
            max-width: 250px;
            padding: 20px;
            text-align: center;
            color: #343a40;
        }

        .stats-box .stats-item h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stats-box .stats-item .stats-number {
            font-size: 36px;
            font-weight: bold;
        }  
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <a href="admin_dashboard.php"><img src="images/gov.png" alt="Logo"></a>
        </div>
        <hr>
        <h2>e-Latihan Industri</h2>
        <h2>(Undang-Undang)</h2>
        
        <hr>
        <ul>
            <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="admin_senaraipemohon.php"><i class="fas fa-file-alt"></i> Senarai Permohonan</a></li>
            <li><a href="admin_appeals.php"><i class="fas fa-address-book"></i> Senarai Rayuan</a></li>
            <li><a href="utility.php"><i class="fas fa-wrench"></i> Utiliti</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Keluar</a></li>
        </ul>
    </div>

    <div class="header">
        <div class="search"> 
            <div class="user-info">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<span>Hi, " . htmlspecialchars($_SESSION['username']) . "</span>";
                } else {
                    echo "<span>Welcome</span>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="main">
        <div class="container1">
            <br><br><br>
            <h2 style="font-size: 40px;"><strong>Senarai Permohonan</strong></h2>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="college_uni">Pilih Kolej:</label>
                    <select name="college_uni" id="college_uni" class="form-control">
                        <option value="">Pilih Kolej</option>
                        <?php foreach ($colleges as $college) : ?>
                            <option value="<?php echo htmlspecialchars($college); ?>" <?php if ($college == $selected_college) echo "selected"; ?>><?php echo htmlspecialchars($college); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="select_college" class="btn btn-primary">Semak Permohonan</button>
            </form>

            <?php if (!empty($application_ids)) : ?>
                <hr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="college_uni" value="<?php echo htmlspecialchars($selected_college); ?>">
                    <div class="form-group">
                        <label for="application_id">Pilih ID Permohonan:</label>
                        <select name="application_id" id="application_id" class="form-control">
                            <option value="">Pilih ID Permohonan</option>
                            <?php foreach ($application_ids as $app_id) : ?>
                                <option value="<?php echo htmlspecialchars($app_id); ?>" <?php if ($app_id == $selected_application_id) echo "selected"; ?>><?php echo htmlspecialchars($app_id); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="select_application" class="btn btn-primary">Lihat Butiran</button>
                </form>
            <?php endif; ?>
                <?php if (!empty($application_details)) : ?>
                    <hr>
                    <div class="row">
                        <!-- Display ID Permohonan -->
                        <div class="form-group col-md-4">
                            <label for="application_id"><b>ID Permohonan:</b></label>
                            <span><?php echo htmlspecialchars($application_details[0]['application_id']); ?></span>
                        </div>
                        <!-- Display Tarikh Mula dan Tamat -->
                        <div class="form-group col-md-4">
                            <label for="start_date"><b>Tarikh Mula:</b></label>
                            <span><?php echo htmlspecialchars($application_details[0]['start_date']); ?></span>
                            </div>
                        <div class="form-group col-md-4">
                            <label for="end_date"><b>Tarikh Tamat:</b></label>
                            <span><?php echo htmlspecialchars($application_details[0]['end_date']); ?></span>
                        </div>
                        <!-- Display Borang Sokongan with Download Icon -->
                        <div class="form-group col-md-4">
                            <label for="borang_sokongan"><b>Borang Sokongan:</b></label>
                            <span>
                                <?php if (!empty($application_details[0]['borang_sokongan'])) : ?>
                                    <a href="uploads/<?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?>" download>
                                        <?php echo htmlspecialchars($application_details[0]['borang_sokongan']); ?>&emsp;<i class="fas fa-download"></i>
                                    </a>
                                <?php else : ?>
                                    No file available
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>

            <?php if (!empty($application_details)) : ?>
                <hr>
                <!-- Add the "Kemaskini Semua" button -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="college_uni" value="<?php echo htmlspecialchars($selected_college); ?>">
                    <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($selected_application_id); ?>">
                    <button type="submit" name="update_all" class="btn btn-warning">Kemaskini Semua "Lulus"</button>
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pelajar</th>
                            <th>No Matrik</th>
                            <th>No IC</th>
                            <th>Kursus</th>
                            <th>Negeri</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Kemaskini Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($application_details as $student) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['student_matrics']); ?></td>
                                <td><?php echo htmlspecialchars($student['student_ic']); ?></td>
                                <td><?php echo htmlspecialchars($student['kursus']); ?></td>
                                <td><?php echo htmlspecialchars($student['negeri']); ?></td>
                                <td><?php echo htmlspecialchars($student['lokasi']); ?></td>
                                <td><?php echo htmlspecialchars($student['status']); ?></td>
                                <td>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="college_uni" value="<?php echo htmlspecialchars($selected_college); ?>">
                                        <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($selected_application_id); ?>">
                                        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">
                                        <select name="status" class="form-control">
                                            <option value="Sedang diproses" <?php if ($student['status'] == 'Sedang diproses') echo "selected"; ?>>Sedang diproses</option>
                                            <option value="Lulus" <?php if ($student['status'] == 'Lulus') echo "selected"; ?>>Lulus</option>
                                            <option value="Tidak Lulus" <?php if ($student['status'] == 'Tidak Lulus') echo "selected"; ?>>Tidak Lulus</option>
                                        </select>
                                        <button type="submit" name="update_status" class="btn btn-success btn-sm mt-2">Kemaskini</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>