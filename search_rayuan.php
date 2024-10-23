<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];

// Fetch all application_ids for the dropdown
try {
    $stmt = $pdo->prepare("
        SELECT DISTINCT application_id 
        FROM rayuan
        WHERE user_id = ?
    ");
    $stmt->execute([$logged_in_user_id]);
    $application_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database query failed: ' . $e->getMessage());
}

$search_application_id = '';
$appeals = [];

if (isset($_GET['application_id']) && !empty($_GET['application_id'])) {
    $search_application_id = $_GET['application_id'];

    try {
        $stmt = $pdo->prepare("
            SELECT rayuan.application_id, students.student_id, students.student_name, students.student_matrics, rayuan.appeal_status
            FROM rayuan
            JOIN students ON rayuan.student_id = students.student_id
            WHERE rayuan.user_id = ? AND rayuan.application_id = ?
        ");
        $stmt->execute([$logged_in_user_id, $search_application_id]);
        $appeals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Database query failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Latihan Industri (Undang-Undang)</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <style>
        .container1 {
            width: 100%;
            max-width: 100%;
            padding: 50px;
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        .dropdown-search {
            position: relative;
        }
        .dropdown-list {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border: 1px solid #ccc;
            z-index: 1000;
        }
        .dropdown-list a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: #000;
        }
        .dropdown-list a:hover {
            background-color: #f0f0f0;
        }
        #loading-spinner {
            display: none;
            margin-top: 5px;
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0; }
        }
        h2 {
            margin-top: 0;
            font-size: 30px;
        }
        .status-processing-row {
            background-color: #ffffe0; 
            color: #000; 
        }

        .status-success-row {
            background-color: #e0ffe0;
            color: #000; 
        }

        .status-failed-row {
            background-color: #ffe0e0; 
            color: #000; 
        }

        .status-processing {
            font-weight: bold;
        }

        .status-success {
            font-weight: bold;
        }

        .status-failed {
            font-weight: bold;
        }
             
        .table {
            border-collapse: collapse; 
        }

        .table-bordered {
            border: 1px solid #a9a9a9; 
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #a9a9a9;
        }
        .status-indicator {
        display: flex;
        align-items: center;
        font-size: 14px;
        }

        .status-indicator .dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 8px; 
        }

        .status-indicator span {
        display: flex;
        align-items: center;
        }

        .status-indicator .green {
        background-color: #c8ffc8;
        }

        .status-indicator .yellow {
        background-color: #fffacd;
        }

        .status-indicator .red {
        background-color: #ffcccc;
        }

    </style>
</head>
<body class="main-layout">
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.php"><img src="images/gov.png" alt="index.php" style="width: 50%;" /></a>&emsp;
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

    <!-- Content -->
    <div class="content-wrapper">
        <div class="full_bg">
            <div class="slider_main">
                <div class="container">
                    <div class="row">
                        <div class="container1">
                            <h2><b>Senarai Rayuan</b></h2><br>
                            
                            <form method="GET" action="search_rayuan.php">
                                <div class="form-group dropdown-search">
                                    <label for="search_application_id">Cari Application ID:</label>
                                    <input type="text" id="search_application_id" name="application_id" class="form-control" autocomplete="off" placeholder="Type Application ID...">
                                    <div id="loading-spinner">
                                        <i class="fas fa-spinner fa-spin"></i> Loading...
                                    </div>
                                    <div id="application_id_dropdown" class="dropdown-list"></div>
                                </div>
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                            <br>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Application ID</th>
                                        <th>Nama Pelajar</th>
                                        <th>No. Matriks</th>
                                        <th>Status Rayuan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($appeals)): ?>
                                        <tr>
                                            <td colspan="5">Tiada rayuan dijumpai untuk Application ID yang dicari.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($appeals as $appeal): ?>
                                            <?php
                                            $status = htmlspecialchars($appeal['appeal_status']);
                                            $row_class = '';
                                            if ($status === 'Dalam Proses') {
                                                $row_class = 'status-processing-row';
                                            } elseif ($status === 'Lulus') {
                                                $row_class = 'status-success-row';
                                            } elseif ($status === 'Tidak Lulus') {
                                                $row_class = 'status-failed-row';
                                            }
                                            ?>
                                            <tr class="<?php echo $row_class; ?>">
                                                <td><?php echo htmlspecialchars($appeal['application_id']); ?></td>
                                                <td><?php echo htmlspecialchars($appeal['student_name']); ?></td>
                                                <td><?php echo htmlspecialchars($appeal['student_matrics']); ?></td>
                                                <td>
                                                    <?php
                                                    if ($status === 'Dalam Proses') {
                                                        echo '<span class="status-processing">Dalam Proses</span>';
                                                    } elseif ($status === 'Lulus') {
                                                        echo '<span class="status-success">Lulus</span>';
                                                    } elseif ($status === 'Tidak Lulus') {
                                                        echo '<span class="status-failed">Tidak Lulus</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <center><a href="rayuan_status.php?application_id=<?php echo htmlspecialchars($appeal['application_id']); ?>&student_id=<?php echo htmlspecialchars($appeal['student_id']); ?>" class="btn-icon">
                                                        <i class="fas fa-eye"></i><center>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="status-indicator">
                            <span class="dot green"></span>Lulus 
                            <span class="dot yellow"></span>Dalam Proses 
                            <span class="dot red"></span>Tidak Lulus 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search_application_id').on('input', function() {
                let searchTerm = $(this).val();
                if (searchTerm.length > 1) {
                    $('#loading-spinner').show();
                    $.ajax({
                        url: 'fetch_application_ids.php',
                        method: 'GET',
                        data: { query: searchTerm },
                        success: function(data) {
                            $('#loading-spinner').hide();
                            $('#application_id_dropdown').html(data);
                        }
                    });
                } else {
                    $('#application_id_dropdown').html('');
                }
            });

            // Set selected application ID from dropdown
            $(document).on('click', '.dropdown-item', function() {
                let selectedId = $(this).text();
                $('#search_application_id').val(selectedId);
                $('#application_id_dropdown').html(''); // Clear dropdown after selection
                $('form').submit(); // Submit the form to trigger search
            });
        });
    </script>
</body>
</html>
