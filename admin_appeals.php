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
        /* Full background */
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh; 
            width: 100vw;  
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            height: 100%;
            position: fixed;
            background-color: #FFC107; /* Yellow background */
            padding: 20px;
            color: #fff;
        }

        .sidebar .logo img {
            width: 150px;
            margin-bottom: 20px; 
        }

        .sidebar h2 {
            font-size: 18px;
            color: #000; /* Black text */
            text-align: center;
            margin: 10px 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #000; /* Black text for links */
            text-decoration: none;
            font-size: 16px;
            display: block;
            padding: 10px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #F8F9FA; /* Light gray on hover */
        }

        /* Main content */
        .main {
            margin-left: 270px;
            padding: 20px;
            background-color: #FFFFFF; /* White background */
        }

        /* Header */
        .header {
            margin-left: 270px;
            background-color: #FFFFFF; /* White background */
            color: #000; /* Black text */
            padding: 10px;
        }

        .header .user-info {
            float: right;
            font-size: 14px;
        }

        /* Table styling */
        .table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 1px solid #000; /* Black borders */
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #343a40; /* Dark background */
            color: #fff; /* White text */
        }

        .table td {
            background-color: #F8F9FA; /* Light gray background */
        }

        /* Button styling */
        .btn-search {
            background-color: #FFC107; /* Yellow background */
            border: none;
            padding: 10px 20px;
            color: #000; /* Black text */
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
            }

            .header {
                margin-left: 0;
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
