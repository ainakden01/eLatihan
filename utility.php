<?php
    session_start();
    include 'db_connect.php'; 

    if (!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
        exit();
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

            /* ****************************BUTTON************************************* */
            .button-container
            {
                
                display: flex;
                flex-direction: column; /* Stack buttons vertically */
                align-items: center;    /* Center the buttons horizontally */
                gap: 20px;              /* Add space between buttons */
                margin-top: 100px;
            }

            .custom-button
            {
                width: 270px;           /* Set a consistent width for the buttons */
                height: 60px;
                background-color: #FFBC00;
                color: white;
                border: none;
                padding: 15px 30px;
                font-size: 16px;
                cursor: pointer;
                border-radius: 5px;
                transition: background-color 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px; /* Add spacing between the icon and text */
            }

            .custom-button i
            {
                font-size: 18px;
            }

            .custom-button:hover
            {
                background-color: #FFCC00;
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


        <div class="button-container">
            <button id="updateUserBtn" class="custom-button">
                <i class="fas fa-share"></i> Kemaskini Pengguna
            </button>
            <button id="adminReportBtn" class="custom-button">
                <i class="fas fa-user-shield"></i> Laporan Admin
            </button>
            <button id="rejectedUserBtn" class="custom-button">
                <i class="fas fa-user-times"></i> Rejected User
            </button>
        </div>

        <!--******************************SCRIPT************************************-->
        <script>
            document.getElementById('updateUserBtn').addEventListener('click', function()
            {
                window.location.href = 'manage_users.php';
            });

            document.getElementById('adminReportBtn').addEventListener('click', function()
            {
                window.location.href = 'admin_report.php';
            });
            document.getElementById('rejectedUserBtn').addEventListener('click', function()
            {
                window.location.href = 'rejected_user.php';
            });
        </script>


        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery-3.0.0.min.js"></script>
        <script src="js/plugin.js"></script>
        <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>
