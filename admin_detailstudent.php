<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['student_id'])) {
    die('Student ID not provided.');
}

$student_id = $_GET['student_id'];
$student_details = [];

try {
    $stmt = $pdo->prepare("SELECT s.student_id, s.student_name, s.student_matrics, s.student_ic, s.negeri_id, s.lokasi_id, s.status,
                            n.negeri, l.lokasi
                            FROM students s
                            INNER JOIN tblnegeri n ON s.negeri_id = n.id_negeri
                            INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                            WHERE s.student_id = :student_id");

    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $student_details = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student_details) {
        die('Student details not found.');
    }
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {

    $status = htmlspecialchars($_POST['status']);

    $valid_statuses = ['Sedang diproses', 'Lulus', 'Tidak Lulus'];
    if (!in_array($status, $valid_statuses)) {
        die('Invalid status.');
    }

    try {
        $update_stmt = $pdo->prepare("UPDATE students SET status = :status WHERE student_id = :student_id");
        $update_stmt->bindParam(':status', $status);
        $update_stmt->bindParam(':student_id', $student_id);

        if ($update_stmt->execute()) {
            header("Location: admin_internapps.php");
            exit();
        } else {
            die('Update failed.');
        }
    } catch (PDOException $e) {
        die('Update query failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
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
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .form-row label {
            width: 100px;
            margin-right: 10px;
        }
        .form-row input,
        .form-row select {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            max-width: 200px; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            white-space: nowrap; 
        }
        .btn-add,
        .btn-delete,
        .btn-logout,
        .btn-check {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-add:hover,
        .btn-check:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-logout {
            background-color: #dc3545;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .btn-logout:hover {
            background-color: #c82333;
        }
        h2 {
            margin-top: 0;
            font-size: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }
    </style>    
</head>
<body class="main-layout">
    <!-- header -->
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.html"><img src="images/gov.png" alt="#" style="width: 50%;" /></a>&emsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12">
                    <i class="fas fa-user"></i>
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<span> Hi, " . htmlspecialchars($_SESSION['username']) . "</span>";
                    } else {
                        echo "<span>Welcome</span>";
                    }
                    ?>
                    <nav class="navigation navbar navbar-expand-md navbar-dark ">
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
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-md-2  d_none">
                    <ul class="email text_align_right">
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end header inner -->
    <div class="full_bg">
        <div class="slider_main">
            <div class="container">
                <div class="row">
                    <div class="container1">
                        <h2 class="text-center mb-4"><b>Student Details</b></h2>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?student_id=" . urlencode($student_id); ?>">
                            <div class="form-group row">
                                <label for="student_name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <p><?php echo htmlspecialchars($student_details['student_name']); ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="student_matrics" class="col-sm-2 col-form-label">Matrics</label>
                                <div class="col-sm-10">
                                    <p><?php echo htmlspecialchars($student_details['student_matrics']); ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="student_ic" class="col-sm-2 col-form-label">IC</label>
                                <div class="col-sm-10">
                                    <p><?php echo htmlspecialchars($student_details['student_ic']); ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="negeri_id" class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-10">
                                    <p><?php echo htmlspecialchars($student_details['negeri']); ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lokasi_id" class="col-sm-2 col-form-label">Location</label>
                                <div class="col-sm-10">
                                    <p><?php echo htmlspecialchars($student_details['lokasi']); ?></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select name="status" class="form-control">
                                        <option value="Sedang diproses" <?php if ($student_details['status'] == 'Sedang diproses') echo 'selected'; ?>>Sedang diproses</option>
                                        <option value="Lulus" <?php if ($student_details['status'] == 'Lulus') echo 'selected'; ?>>Lulus</option>
                                        <option value="Tidak Lulus" <?php if ($student_details['status'] == 'Tidak Lulus') echo 'selected'; ?>>Tidak Lulus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                    <a href="admin_internapps.php" class="btn btn-secondary">Back to List</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
