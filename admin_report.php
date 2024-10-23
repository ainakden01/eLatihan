<?php
    session_start();
    include 'db_connect.php'; 

    // Check if admin session exists
    if (!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
        exit();
    }

    // Fetch all colleges from the users table
    try
    {
        $stmt = $pdo->query("SELECT DISTINCT college_uni FROM users ORDER BY college_uni ASC");
        $colleges = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e)
    {
        die('Database connection failed: ' . $e->getMessage());
    }

    // Initialize variables
    $selected_college = '';
    $application_ids = [];
    $selected_application_id = '';
    $application_details = [];

    // Fetch application IDs based on selected college
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_college']))
    {
        $selected_college = $_POST['college_uni'];

        try
        {
            $stmt = $pdo->prepare("SELECT ia.application_id
                                FROM internship_applications ia
                                INNER JOIN users u ON ia.user_id = u.user_id
                                WHERE u.college_uni = :college_uni");
            $stmt->bindParam(':college_uni', $selected_college);
            $stmt->execute();
            $application_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        catch (PDOException $e)
        {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // Fetch application details based on selected application ID
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_application']))
    {
        $selected_application_id = $_POST['application_id'];

        try
        {
            $stmt = $pdo->prepare("SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status
                                FROM internship_applications ia
                                INNER JOIN students s ON ia.application_id = s.application_id
                                INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                                INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                                WHERE ia.application_id = :application_id");
            $stmt->bindParam(':application_id', $selected_application_id);
            $stmt->execute();
            $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    //Process form input and filter the results based on the selected options
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_report'])) {
        $selected_college = $_POST['college_uni'];
        $selected_year = $_POST['year'];
        $selected_status = $_POST['status'];
    
        $query = "SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status
          FROM internship_applications ia
          INNER JOIN students s ON ia.application_id = s.application_id
          INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
          INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
          INNER JOIN users u ON ia.user_id = u.user_id
          WHERE 1=1"; // Always true to add further conditions

    
        $params = [];
    
        // Filter by selected college
        if (!empty($selected_college)) {
            $query .= " AND u.college_uni = :college_uni";
            $params[':college_uni'] = $selected_college;
        }
    
        // Filter by selected year
        if (!empty($selected_year)) {
            $query .= " AND YEAR(ia.start_date) = :year";
            $params[':year'] = $selected_year;
        }
    
        // Filter by selected status
        if (!empty($selected_status)) {
            $query .= " AND s.status = :status";
            $params[':status'] = $selected_status;
        }
    
        $stmt = $pdo->prepare($query);
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->execute();
        $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <li><a href="admin_appeal_list.php"><i class="fas fa-address-book"></i> Senarai Rayuan</a></li>
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
                <h2 style="font-size: 40px;"><strong>Laporan Admin</strong></h2>
                
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!--____________________________________PILIH KOLEJ SECTION_____________________________________________-->
                    <div class="form-group">
                        <label for="college_uni">Pilih Kolej:</label>
                        <select name="college_uni" id="college_uni" class="form-control">
                            <option value="">Pilih Kolej</option>
                            <?php foreach ($colleges as $college) : ?>
                                <option value="<?php echo htmlspecialchars($college); ?>" <?php if ($college == $selected_college) echo "selected"; ?>><?php echo htmlspecialchars($college); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!--____________________________________END OF PILIH KOLEJ SECTION_____________________________________________-->

                    <!--____________________________________CHOOSE YEAR SECTION_____________________________________________-->
                    <div class="form-group">
                        <label for="year">Pilih Tahun:</label>
                        <select name="year" id="year" class="form-control">
                            <option value="">All</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <!-- Add more years as needed -->
                        </select>
                    </div>
                    <!--____________________________________END OF CHOOSE YEAR SECTION_____________________________________________-->

                    <!--____________________________________CHOOSE STATUS SECTION_____________________________________________-->
                    <div class="form-group">
                        <label for="status">Application Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <!--____________________________________END OF CHOOSE STATUS SECTION_____________________________________________-->

                    <!--____________________________________BUTTON SECTION_____________________________________________-->
                    <button type="submit" name="check_report" class="btn btn-primary">Check</button>
                </form>

                <?php if (!empty($application_details)) : ?>
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
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <form method="post" action="export_pdf_report.php">
                        <button type="submit" class="btn btn-success">Export to PDF</button>
                    </form>
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