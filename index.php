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

            /* ************************FOR INFOGRAPHIC************************** */
            .infographic-container
            {
                width: 60%; /* Adjust this to your desired infographic width */
                margin: 20px auto; /* Center the infographic box */
                text-align: center;
                position: absolute; /* Change from fixed to absolute */
                top: 70%; /* Move it to the middle of the page vertically */
                left: 50%; /* Move it to the middle of the page horizontally */
                transform: translate(-50%, -50%); /* Center it both horizontally and vertically */
                z-index: 1; 
            }

            .infographic-slides
            {
                width: 100%;
                height: 350px;
                overflow: hidden;
                position: relative;
                display: flex;
            }

            .slide
            {
                width: 100%;
                height: 100%;
                flex-shrink: 0;
                display: none; /* Hide all slides by default */
                justify-content: center;
                align-items: center;
            }

            .slide.active
            {
                display: flex; /* Show the active slide */
            }

            .slide img
            {
                width: 100%; /* Ensure the image fits the width of the slide */
                height: auto; /* Maintain image aspect ratio */
                object-fit: cover; /* Optional: crop the image if it doesn't fit perfectly */
            }

            .slide-navigation
            {
                position: absolute;
                bottom: 10px;
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            button.prev-slide, button.next-slide
            {
                background-color: #ffcc00;
                border: none;
                padding: 10px;
                cursor: pointer;
            }

            button.prev-slide:hover, button.next-slide:hover
            {
                background-color: #ff9900;
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
                                        <h1>
                                            <br>e-Latihan Industri <br>(Undang-Undang)
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end banner -->

        <!--*********************************INFOGRAPHIC SLIDE*****************************-->
        <div class="infographic-container">
            <div class="infographic-slides">
                <div class="slide active">
                    <!-- Image for Slide 1 -->
                    <img src="images/image1.jpeg" alt="Infographic Slide 1">
                </div>
                <div class="slide">
                    <!-- Image for Slide 2 -->
                    <img src="images/image2.jpeg" alt="Infographic Slide 2">
                </div>
                <div class="slide">
                    <!-- Image for Slide 3 -->
                    <img src="images/image3.jpeg" alt="Infographic Slide 3">
                </div>
                <div class="slide">
                    <!-- Image for Slide 4 -->
                    <img src="images/image4.jpeg" alt="Infographic Slide 4">
                </div>
            </div>

            <div class="slide-navigation">
                <button class="prev-slide">&lt;</button>
                <button class="next-slide">&gt;</button>
            </div>
        </div>

        <script>
            const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;

            document.querySelector('.next-slide').addEventListener('click', function()
            {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            });

            document.querySelector('.prev-slide').addEventListener('click', function()
            {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
            });

            setInterval(function()
            {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 5000); // 5000ms = 5 seconds per slide

        </script>
        <!--*********************************END OF INFOGRAPHIC SLIDE*****************************-->

        <!-- Javascript files-->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
    </body>
</html>
