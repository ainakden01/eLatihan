<?php
    session_start();
    include 'db_connect.php'; 

    if (!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
        exit();
    }

    try
    {
        // Added port to the connection
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch all appeal applicants
        $stmt = $pdo->query("SELECT rayuan_id, application_id, id_lokasi, appeal_status, remarks FROM rayuan");
        $applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Handle approval or rejection of an appeal
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $applicantId = $_POST['applicant_id'];
            $action = $_POST['action']; // Either 'approve' or 'reject'

            if ($action === 'approve')
            {
                $updateStmt = $pdo->prepare("UPDATE rayuan SET appeal_status = 'Approved' WHERE rayuan_id = ?");
            }
            else
            {
                $updateStmt = $pdo->prepare("UPDATE rayuan SET appeal_status = 'Rejected' WHERE rayuan_id = ?");
            }

            $updateStmt->execute([$applicantId]);
            // Refresh the page to reflect changes
            header('Location: admin_appeal_list.php');
            exit;
        }

    }
    catch (PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
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

        <div class="main">
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
            <h1>List of Applicants Who Made an Appeal</h1>
            <table id="appealTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Application Status</th>
                        <th>Appeal Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applicants)): ?>
                        <?php foreach ($applicants as $applicant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($applicant['rayuan_id']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['application_id']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['id_lokasi']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['appeal_status']); ?></td>
                            <td><?php echo htmlspecialchars($applicant['remarks']); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="applicant_id" value="<?php echo $applicant['rayuan_id']; ?>">
                                    <button type="submit" name="action" value="approve">Approve</button>
                                    <button type="submit" name="action" value="reject">Reject</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">No appeals found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
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