<?php
    session_start();

    if (!isset($_SESSION['admin_id']))
    {
        header("Location: login.php");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "intern";
    $port = "3307";

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die("Connection failed: " . $e->getMessage());
    }

    // Query for users awaiting approval
    $query_pending = "SELECT * FROM requests WHERE status = 'pending'";
    $stmt_pending = $conn->prepare($query_pending);
    $stmt_pending->execute();
    $result_pending = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);

    // Query for approved users
    $query_approved = "SELECT * FROM users WHERE status = 'approved'";
    $stmt_approved = $conn->prepare($query_approved);
    $stmt_approved->execute();
    $result_approved = $stmt_approved->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>e-Latihan Industri(Undang-Undang)</title>
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

            .main h2 {
                font-size: 24px;
                margin-top: 40px;
                margin-bottom: 10px;
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

            /* **********************REMOVE BUTTON**************************** */
            .remove-button {
                background-color: red;
                color: white;
                border: none;
                padding: 10px 15px;
                margin-left: 10px;
                cursor: pointer;
            }

            .remove-button:hover {
                background-color: darkred;
            }

            /* ***********************ADD BUTTON*************************** */
            .add-button {
                position: fixed;
                bottom: 20px;
                right: 20px;
                padding: 10px 20px;
                font-size: 16px;
                z-index: 1000;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
            .add-button:hover {
                background-color: #218838;
            }

            /* ***********************APPROVE REJECT BUTTON*************************** */
            .approve-btn, .reject-btn {
                padding: 8px 12px;
                border: none;
                cursor: pointer;
                color: white;
            }

            .approve-btn {
                background-color: green;
            }

            .reject-btn {
                background-color: red;
            }
        </style>
    </head>

    <body>
        <!--______________________________________SIDE BAR_____________________________________________-->
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
        <!--___________________________________END OF SIDEBAR______________________________________________-->

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

        <!--________________________________________USER AWAITING___________________________________________-->
        <div class="main">
            <h2>Users Awaiting Approval</h2>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Institusi</th>
                        <th>Email</th>
                        <th>No Telefon</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach($result_pending as $row):  ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['college_uni']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['no_phone']; ?></td>
                            <td>
                                <button class="approve-btn" onclick="handleApproval(<?php echo $row['id']; ?>, 'approve')">Approve</button>
                                <button class="reject-btn" onclick="handleApproval(<?php echo $row['id']; ?>, 'reject')">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <script>
            function handleApproval(userId, action)
            {
                const formData = new FormData();
                formData.append('user_id', userId);
                formData.append('action', action);

                fetch('process_approval.php',
                {
                    method: 'POST',
                    body: formData
                }).then(response => response.text())
                .then(data =>
                {
                    if (data === 'success')
                    {
                        location.reload();
                    }
                    else
                    {
                        alert('Failed to process request');
                    }
                });
            }
        </script>
        <!--_______________________________________END OF USER AWAITING_____________________________________-->

        <!--_______________________________________APPROVED USER_______________________________________________-->
        <div class="main">
            <h1>Approved Users</h1>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Institusi</th>
                        <th>Email</th>
                        <th>No Telefon</th>
                        <th>Kemaskini</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach($result_approved as $row): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $row['college_uni']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['no_phone']; ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="<?php echo htmlspecialchars($row['user_id']); ?>" data-college_uni="<?php echo htmlspecialchars($row['college_uni']); ?>" data-email="<?php echo htmlspecialchars($row['email']); ?>" data-phone="<?php echo htmlspecialchars($row['no_phone']); ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!--________________________________________END OF USER APPROVED________________________________________-->

        <!--
        <div class="main">
            <h2>Manage Users</h2>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Institusi</th>
                        <th>Email</th>
                        <th>No Telefon</th>
                        <th>Kemaskini</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php /*foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['college_uni']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['no_phone']); ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="<?php echo htmlspecialchars($user['user_id']); ?>" data-college_uni="<?php echo htmlspecialchars($user['college_uni']); ?>" data-email="<?php echo htmlspecialchars($user['email']); ?>" data-phone="<?php echo htmlspecialchars($user['no_phone']); ?>">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; */?>
                </tbody>
            </table>
        </div>
        -->

        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="update_user.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Kemaskini Pengguna</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="editUserId">
                            <!--
                            <div class="form-group">
                                <label for="editCollegeUni">Institusi</label>
                                <input type="text" class="form-control" name="college_uni" id="editCollegeUni" required>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>
                            -->
                            <div class="form-group">
                                <label for="editPhone">No Telefon</label>
                                <input type="text" class="form-control" name="no_phone" id="editPhone" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                            <button type="button" id="removeData" class="remove-button">Remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            $('#editUserModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                var collegeUni = button.data('college_uni');
                var email = button.data('email');
                var phone = button.data('phone');

                var modal = $(this);
                modal.find('#editUserId').val(userId);
                modal.find('#editCollegeUni').val(collegeUni);
                modal.find('#editEmail').val(email);
                modal.find('#editPhone').val(phone);
            });
        </script>
        <script>
            document.getElementById("removeData").addEventListener("click", function() {
                const userId = document.getElementById("user_id").value;

                if (confirm("Are you sure you want to delete this institute?")) {
                    // Make an AJAX request to delete the institute
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete_institute.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onreadystatechange = function()
                    {
                        if (xhr.readyState == 4 && xhr.status == 200)
                        {
                            alert("Institute deleted successfully.");
                            // Optionally, you can refresh the table or redirect the user
                            window.location.reload();
                        }
                    };

                    xhr.send("user_id=" + userId);
                }
            });
        </script>

        <!--*******************************ADD BUTTON************************************-->
        <div class="main">
            <button class="btn btn-success" data-toggle="modal" data-target="#addUserModal">Add New Institute</button>
        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="add_user.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Tambah Institut Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="addCollegeUni">Institusi</label>
                                <input type="text" class="form-control" name="college_uni" id="addCollegeUni" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="addEmail">Email</label>
                                <input type="email" class="form-control" name="email" id="addEmail" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="addPegawai">Nama Pegawai</label>
                                <input type="text" class="form-control" name="nama_pegawai" id="addPegawai" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="addPhone">No Telefon</label>
                                <input type="text" class="form-control" name="no_phone" id="addPhone" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="addPass">Kata Laluan</label>
                                <input type="text" class="form-control" name="password" id="addPass" required autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah Institut</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html> 
