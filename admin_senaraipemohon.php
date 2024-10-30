<?php
    session_start();
    include 'db_connect.php'; 

    // Check if admin session exists
    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }

    // Define the number of applications per page
    $limit = 10;

    // Get the current page number from the query string (default to 1 if not set)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1)
    {
        $page = 1;
    }

    // Calculate the offset
    $offset = ($page - 1) * $limit;

    // Fetch the total number of applications to calculate total pages
    $total_stmt = $pdo->query("
        SELECT COUNT(*) FROM internship_applications ia
        INNER JOIN students s ON ia.application_id = s.application_id
        WHERE s.status = 'Sedang diproses'
    ");
    $total_applications = $total_stmt->fetchColumn();
    $total_pages = ceil($total_applications / $limit);

    // Fetch applications for the current page
    try
    {
        $stmt = $pdo->prepare("
            SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.country, s.status
            FROM internship_applications ia
            INNER JOIN students s ON ia.application_id = s.application_id
            INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
            INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
            WHERE s.status = 'Sedang diproses'
            ORDER BY ia.application_id DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        die('Database connection failed: ' . $e->getMessage());
    }

    // Fetch all new applications
    /*try {
        $stmt = $pdo->query("
            SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status
            FROM internship_applications ia
            INNER JOIN students s ON ia.application_id = s.application_id
            INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
            INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
            WHERE s.status = 'Sedang diproses'
            ORDER BY ia.application_id DESC
        ");
        $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Database connection failed: ' . $e->getMessage());
    }*/

    // Handle status update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
        $student_id = $_POST['student_id'];
        $new_status = $_POST['status'];

        try {
            $stmt = $pdo->prepare("UPDATE students SET status = :status WHERE student_id = :student_id");
            $stmt->bindParam(':status', $new_status);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();

            // Re-fetch the application details to display updated status
            $stmt = $pdo->query("
                SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.country,s.status
                FROM internship_applications ia
                INNER JOIN students s ON ia.application_id = s.application_id
                INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                WHERE s.status = 'Sedang diproses'
                ORDER BY ia.application_id DESC
            ");
            $application_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // Handle bulk status update to "Lulus"
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_all'])) {
        try {
            // Update all students' status to "Lulus"
            $stmt = $pdo->prepare("UPDATE students SET status = 'Lulus' WHERE status = 'Sedang diproses'");
            $stmt->execute();

            // Re-fetch the application details to display updated status
            $stmt = $pdo->query("
                SELECT ia.application_id, ia.borang_sokongan, ia.start_date, ia.end_date, s.student_id, s.student_name, s.student_matrics, s.student_ic, s.kursus, n.negeri, l.lokasi, s.status
                FROM internship_applications ia
                INNER JOIN students s ON ia.application_id = s.application_id
                INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                WHERE s.status = 'Sedang diproses'
                ORDER BY ia.application_id DESC
            ");
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

            /* ******************PAGENATION******************** */
            .pagination
            {
                display: flex;
                justify-content: center;
                list-style: none;
                padding: 0;
            }

            .pagination li
            {
                margin: 0 5px;
            }

            .pagination li a
            {
                color: #007bff;
                text-decoration: none;
                padding: 8px 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .pagination li a:hover
            {
                background-color: #007bff;
                color: white;
            }

            .pagination .active a
            {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
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
                
                <?php if (!empty($application_details)) : ?>
                    <hr>
                    <!-- Add the "Kemaskini Semua" button -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                                <th>Negara</th>
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
                                    <td><?php echo htmlspecialchars($student['country']); ?></td>
                                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                                    <td>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">
                                            <select name="status" class="form-control">
                                                <option value="Sedang diproses" <?php if ($student['status'] == 'Sedang diproses') echo "selected"; ?>>Sedang diproses</option>
                                                <option value="Lulus" <?php if ($student['status'] == 'Lulus') echo "selected"; ?>>Lulus</option>
                                                <option value="Tidak Lulus" <?php if ($student['status'] == 'Tidak Lulus') echo "selected"; ?>>Tidak Lulus</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-primary">Kemaskini</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="<?php echo $i == $page ? 'active' : ''; ?>">
                                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>

                <?php else : ?>
                    <p>Tiada permohonan baru buat masa ini.</p>
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