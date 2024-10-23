<?php
session_start();
include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>e-Latihan Industri(Undang-Undang)</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh; 
            width: 100vw;  
            position: absolute;
            top: 0;
            left: 0;
        }
        .dropdown {
            max-width: 300px;
        }
        .read_more {
            background: #ffe6a1;
            color: #000;
        }
        .read_more:hover,
        .read_more.dropdown-toggle:hover {
            background: #ffe6a1;
            color: #000;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #ffbc00;
        }
    </style>
</head>
<body class="main-layout">
    <!-- loader  -->
    <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#"/></div>
    </div>
    <!-- end loader -->
    <!-- header -->
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.php"><img src="images/gov.png" alt="#" style="width: 50%;" /></a>&emsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <i class="fas fa-user"></i>         
                    <?php
                    if (isset($_SESSION['college_uni'])) {
                        echo "<span> Hi, " . htmlspecialchars($_SESSION['college_uni']) . "</span>";
                    } else {
                        echo "<span>Welcome</span>";
                    }
                    ?>
                    <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="daftar1.php">Daftar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="display.php">Permohonan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="search_rayuan.php">Rayuan</a>
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
    <!-- end header inner -->
    <!-- top -->
    <div class="full_bg">
        <div class="slider_main">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="dream">
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end banner -->
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
