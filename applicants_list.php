<?php
    session_start();
    include 'db_connect.php';

    if (!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
        exit();
    }

    $filter = $_GET['filter'] ?? 'all';
    $whereClause = '';

    switch ($filter)
    {
        case 'approved':
            $whereClause = "WHERE students.status = 'Lulus' 
                            OR (rayuan.student_id IS NOT NULL AND rayuan.appeal_status = 'Approved')";
            $title = "Permohonan Berjaya";
            break;
        case 'disapproved':
            $whereClause = "WHERE status = 'Tidak Lulus'";
            $title = "Permohonan Tidak Berjaya";
            break;
        case 'pending':
            $whereClause = "WHERE status = 'Sedang Diproses'";
            $title = "Permohonan Untuk Tindakan";
            break;
        default:
            $title = "Jumlah Permohonan";
    }

    try
    {
        // Join students with rayuan to get both approved students and approved appeals
        $stmt = $pdo->prepare("
            SELECT students.*, rayuan.appeal_status 
            FROM students 
            LEFT JOIN rayuan ON students.student_id = rayuan.student_id
            $whereClause
        ");
        $stmt->execute();
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e)
    {
        die('Database connection failed: ' . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
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

        <div class="container mt-5">
            <h2><?php echo $title; ?></h2>

            <?php if ($filter === 'pending'): ?>
                <div class="mb-3">
                    <label for="statusDropdown" class="form-label">Kemaskini Status</label>
                    <select id="statusDropdown" class="form-select">
                        <option value="Sedang Diproses">Sedang Diproses</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                    <button id="updateStatusBtn" class="btn btn-primary mt-2">Kemaskini</button>
                </div>
            <?php endif; ?>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID Permohonan</th>
                        <th>Nama</th>
                        <th>No. kad pengenalan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($application['student_id']); ?></td>
                            <td><?php echo htmlspecialchars($application['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($application['student_ic']); ?></td>
                            <td><?php echo htmlspecialchars($application['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
            document.getElementById('updateStatusBtn')?.addEventListener('click', function() {
                const newStatus = document.getElementById('statusDropdown').value;
                // Implement AJAX or a form to update the status in the database.
                alert('Updating status to: ' + newStatus);
            });
        </script>
    </body>
</html>
