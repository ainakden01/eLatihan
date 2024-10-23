<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['college_uni'])) {
    header("Location: index.php");
    exit();
}

// Get student ID and application ID from the query parameters
$student_id = isset($_GET['student_id']) ? htmlspecialchars($_GET['student_id']) : '';
$application_id = isset($_GET['application_id']) ? htmlspecialchars($_GET['application_id']) : '';

if (empty($student_id) || empty($application_id)) {
    die('Student ID or Application ID is missing.');
}

try {
    // Fetch student details
    $stmt = $pdo->prepare("SELECT s.student_name, s.student_matrics, l.lokasi AS current_location
                           FROM students s
                           INNER JOIN tbllokasi l ON s.lokasi_id = l.id_lokasi
                           WHERE s.student_id = ?");
    $stmt->execute([$student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die('No student information found for this ID.');
    }

    // Fetch available locations
    $stmt = $pdo->query("SELECT id_lokasi, lokasi FROM tbllokasi");
    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_lokasi = $_POST['id_lokasi'];
    $remarks = $_POST['remarks'];
    $appeal_status = 'Dalam Proses';
    $user_id = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : '';

    // Debug statement
    var_dump($user_id);

    if (empty($user_id)) {
        die('User ID is missing.');
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO rayuan (application_id, id_lokasi, appeal_status, remarks, user_id) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$application_id, $id_lokasi, $appeal_status, $remarks, $user_id]);

        // Trigger the success modal
        echo "<script>document.getElementById('applicationId').textContent = '$application_id';</script>";
        echo "<script>document.getElementById('successModal').style.display = 'block';</script>";
    } catch (PDOException $e) {
        die('Database query failed: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Latihan Industri(Undang-Undang)</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif">
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
        .btn-appeal {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-appeal:hover {
            background-color: #0056b3;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .status-failed {
            font-size: 24px;
            color: red;
            font-weight: bold;
            animation: blink 3.5s infinite;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0; }
        }
        /* Modal Styling */
        #successModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            text-align: center;
        }
        .modal-content img {
            width: 50px;
            height: 50px;
        }
        .modal-content h2 {
            color: green;
        }
        .modal-content button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }
        .modal-content button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body class="main-layout">
    <!-- Header -->
    <div class="header">
        <div class="container">
            <div class="row d_flex">
                <div class="col-md-2 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.php"><img src="images/gov.png" alt="index.php" style="width: 50%;" /></a>
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
                        <li><a href="logout.php">Log Keluar</a></li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header -->

    <div class="content-wrapper">
        <div class="full_bg">
            <div class="slider_main">
                <div class="container">
                    <div class="row">
                        <div class="container1">
                            <h2><b>Permohonan anda telah <span class="status-failed">TIDAK DAPAT DIPERTIMBANGKAN</span></b></h2><br>
                            <h2><b>Borang Permohonan Rayuan</b></h2><br>
                            <div class="message">
                                <p>Harap maklum bahawa permohonan anda tidak berjaya kerana lokasi yang dipilih telah mencapai kapasiti penuh dan tiada kekosongan yang tersedia. Sila pilih lokasi lain untuk permohonan rayuan.<br>Sebarang pertanyaan sila hubungi (no telefon) dan  (email)</p>
                            </div>
                            <form method="post" action="rayuan_hantar.php">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                                <?php
                                    try {
                                        $stmt = $pdo->prepare("SELECT id_negeri, negeri FROM tblnegeri ORDER BY negeri ASC");
                                        $stmt->execute();
                                        $states = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    } catch (PDOException $e) {
                                        die('Database connection failed: ' . $e->getMessage());
                                    }
                                    ?>
                                <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
                                <div class="form-group">
                                    <label for="application_id">ID Permohonan:</label>
                                    <input type="text" class="form-control" id="application_id" name="application_id" value="<?php echo htmlspecialchars($application_id); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="student_name">Nama Pelajar:</label>
                                    <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student['student_name']); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="student_matrics">No Matriks Pelajar:</label>
                                    <input type="text" class="form-control" id="student_matrics" name="student_matrics" value="<?php echo htmlspecialchars($student['student_matrics']); ?>" readonly>
                                </div>

                                
                                <div class="form-group">
                                    <label for="id_negeri">Pilih Negeri:</label>
                                    <select class="form-control" name="id_negeri[]" onchange="reload(this)" required>
                                        <option value="">Pilih Negeri</option>
                                        <?php foreach ($states as $state) : ?>
                                            <option value="<?php echo $state['id_negeri']; ?>"><?php echo htmlspecialchars($state['negeri']); ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <label for="id_lokasi">Pilih Lokasi:</label>
                                    <select class="form-control" name="id_lokasi[]" required>
                                        <option value="">Pilih Lokasi</option>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <label for="remarks">Alasan:</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                                <button type="submit" class="btn-appeal">Hantar Rayuan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal">
        <div class="modal-content">
            <img src="images/checkmark.png" alt="success">
            <h2>Rayuan Berjaya Dihantar!</h2>
            <p>Permohonan ID: <span id="applicationId"></span></p>
            <a href="index.php"><button>Kembali</button></a>
            <a href="status_rayuan.php"><button>Semak Status Rayuan</button></a>
        </div>
    </div>

    <script>
        function reload(selectElement) {
             const stateId = selectElement.value;
             const locationSelect = selectElement.nextElementSibling;
             
             locationSelect.innerHTML = '<option value="">Pilih Lokasi</option>';

             if (stateId !== '') {
                 fetch(`get_locations.php?state_id=${stateId}`)
                     .then(response => response.json())
                     .then(data => {
                         data.forEach(location => {
                             const option = document.createElement('option');
                             option.value = location.id_lokasi;
                             option.textContent = location.lokasi;
                             locationSelect.appendChild(option);
                         });
                     })
                     .catch(error => console.error('Error fetching locations:', error));
             }
         }
         
         function reload(select) {
                                    const stateId = select.value;
                                    const xhr = new XMLHttpRequest();
                                    xhr.open('GET', 'get_locations.php?id_negeri=' + stateId, true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            const locations = JSON.parse(xhr.responseText);
                                            const locationSelect = select.parentNode.querySelector('select[name="id_lokasi[]"]');
                                            locationSelect.innerHTML = '<option value="">Pilih Lokasi</option>';
                                            locations.forEach(location => {
                                                const option = document.createElement('option');
                                                option.value = location.id_lokasi;
                                                option.text = location.lokasi;
                                                locationSelect.appendChild(option);
                                            });
                                        }
                                    };
                                    xhr.send();
                                }

                                updateLabels();
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
