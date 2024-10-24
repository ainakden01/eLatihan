<?php
session_start();
include 'db_connect.php'; 

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Fetch appeal status from the database
    $stmt = $pdo->query("SELECT rayuan_id, application_id, id_lokasi, appeal_status, remarks, student_id, user_id FROM rayuan");
    $appeals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Handle approval/rejection of appeals
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rayuan_id = $_POST['rayuan_id'];
    $action = $_POST['action'];

    try {
        if ($action == 'approve') {
            $update_stmt = $pdo->prepare("UPDATE rayuan SET appeal_status = 'Approved' WHERE rayuan_id = ?");
            $update_stmt->execute([$rayuan_id]);
        } elseif ($action == 'reject') {
            $update_stmt = $pdo->prepare("UPDATE rayuan SET appeal_status = 'Rejected' WHERE rayuan_id = ?");
            $update_stmt->execute([$rayuan_id]);
        }
        header("Location: admin_appeals.php"); // Redirect after update
        exit();
    } catch (PDOException $e) {
        die('Update failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Admin Appeals Status</title>
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

            #appealTable
        {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }

        #appealTable th, #appealTable td
        {
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            text-align: left;
            vertical-align: middle;
        }

        /* Header Row Styling */
        #appealTable thead th
        {
            background-color: #2a2a2a;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        /* Body Row Styling */
        #appealTable tbody tr:nth-child(odd)
        {
            background-color: #f9f9f9;
        }

        #appealTable tbody tr:nth-child(even)
        {
            background-color: #fff;
        }

        #appealTable tbody tr:hover
        {
            background-color: #f1f1f1;
        }

        /* Pagination Styling */
        .pagination
        {
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        .pagination a
        {
            color: #333;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a.active
        {
            background-color: #2a2a2a;
            color: white;
            border: 1px solid #2a2a2a;
        }

        .pagination a:hover:not(.active)
        {
            background-color: #ddd;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px)
        {
            #appealTable thead {
                display: none;
            }

            #appealTable tbody tr {
                display: block;
                margin-bottom: 15px;
            }

            #appealTable tbody tr td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            #appealTable tbody tr td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 15px;
                font-weight: bold;
                text-align: left;
            }
        }

    </style>
</head>
<body class="main-layout">
    <div class="full_bg">
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
                <li><a href="admin_appeals.php"><i class="fas fa-file-alt"></i> Senarai Rayuan</a></li>
                <li><a href="admin_laporan.php"><i class="fas fa-user-shield"></i> Laporan Admin</a></li>
                <li><a href="manage_users.php"><i class="fas fa-share"></i> Kemaskini Pengguna</a></li>
                <li><a href="admin_appeals.php"><i class="fas fa-file-alt"></i> Semakan Rayuan</a></li>
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
            <h2>Status Rayuan</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rayuan ID</th>
                        <th>Application ID</th>
                        <th>Location ID</th>
                        <th>Status Rayuan</th>
                        <th>Remarks</th>
                        <th>Student ID</th>
                        <th>User ID</th>
                        <th>Actions</th> <!-- Added Actions header -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appeals as $appeal): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appeal['rayuan_id']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['application_id']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['id_lokasi']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['appeal_status']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['remarks']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($appeal['user_id']); ?></td>
                            <td>
                                <?php 
                                // Debugging Output
                                // Uncomment the following line to debug output
                                // echo "<pre>"; print_r($appeal); echo "</pre>"; 
                                ?>
                                <?php if ($appeal['appeal_status'] == 'Dalam Proses'): ?>
                                    <form method="POST" action="admin_appeals.php" style="display:inline;">
                                        <input type="hidden" name="rayuan_id" value="<?php echo $appeal['rayuan_id']; ?>">
                                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="admin_appeals.php" style="display:inline;">
                                        <input type="hidden" name="rayuan_id" value="<?php echo $appeal['rayuan_id']; ?>">
                                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                    </form>
                                <?php else: ?>
                                    <span><?php echo htmlspecialchars($appeal['appeal_status']); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
