<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
try {
    $stmt = $pdo->query("SELECT COUNT(*) AS total_applications FROM internship_applications");
    $total_applications = $stmt->fetchColumn();
    $stmt = $pdo->query("SELECT COUNT(*) AS pending FROM students WHERE status = 'Sedang Diproses'");
    $pending_applications = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) AS approved FROM students WHERE status = 'Lulus'");
    $approved_applications = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) AS disapproved FROM students WHERE status = 'Tidak Lulus'");
    $disapproved_applications = $stmt->fetchColumn();

    $stmt = $pdo->query("
        SELECT 
            ia.application_id,
            ia.start_date, 
            ia.end_date,
            u.college_uni
        FROM 
            internship_applications ia
        JOIN
            users u ON ia.user_id = u.user_id
        ORDER BY 
            ia.application_id DESC 
    ");
    $recent_applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
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

            .container {
                margin-left: 250px;
                max-width: calc(100% - 250px);
                padding: 20px;
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
                width: 100%; 
                overflow-x: auto; 
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
                    if (isset($_SESSION['username']))
                    {
                        echo "<span>Hi, " . htmlspecialchars($_SESSION['username']) . "</span>";
                    }
                    else
                    {
                        echo "<span>Welcome</span>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="main">
            <h2>eLatihan Industri (Undang-Undang)</h2>
            <div class="stats-box">
                <div class="stats-item">
                    <h3>Jumlah Permohonan</h3>
                    <div class="stats-number">
                        <a href="applicants_list.php?filter=all"><?php echo $total_applications; ?></a>
                    </div>
                </div>
                <div class="stats-item">
                    <h3>Permohonan Berjaya</h3>
                    <div class="stats-number">
                        <a href="applicants_list.php?filter=approved"><?php echo $approved_applications; ?></a>
                    </div>
                </div>
                <div class="stats-item">
                    <h3>Permohonan Tidak Berjaya</h3>
                    <div class="stats-number">
                        <a href="applicants_list.php?filter=disapproved"><?php echo $disapproved_applications; ?></a>
                    </div>
                </div>
                <div class="stats-item">
                    <h3>Permohonan Untuk Tindakan</h3>
                    <div class="stats-number">
                        <a href="applicants_list.php?filter=pending"><?php echo $pending_applications; ?></a>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2>Permohonan Kini</h2>
                </div>

                <!-- Search Form on the Right -->
                <div class="col-md-4 text-end">
                    <form method="GET" action="">
                        <div class="input-group">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" style="background-color:#FFBC00;"class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Table -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Permohonan</th>
                        <th>Institusi</th>
                        <th>Tarikh Mula</th>
                        <th>Tarikh Tamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get the current page from the query string, default to 1 if not set
                    $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $items_per_page = 10;
                    $start_index = ($current_page - 1) * $items_per_page;

                    // Filter and paginate applications
                    $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                    $filtered_applications = array_filter($recent_applications, function($application) use ($search) {
                        return strpos($application['application_id'], $search) !== false ||
                            strpos($application['college_uni'], $search) !== false;
                    });

                    $total_applications = count($filtered_applications);
                    $total_pages = ceil($total_applications / $items_per_page);
                    $paged_applications = array_slice($filtered_applications, $start_index, $items_per_page);

                    foreach ($paged_applications as $application): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['application_id']); ?></td>
                            <td><?php echo htmlspecialchars($application['college_uni']); ?></td>
                            <td><?php echo htmlspecialchars($application['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($application['end_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $current_page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $current_page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
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
