<?php
/*
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "intern";
    $port = "3307";

    $conn = new mysqli($servername, $username, $password, $dbname, port: $port);

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query for users awaiting approval
    $query_pending = "SELECT * FROM users WHERE status = 'pending'";
    $result_pending = mysqli_query($conn, $query_pending);

    // Query for approved users
    $query_approved = "SELECT * FROM users WHERE status = 'approved'";
    $result_approved = mysqli_query($conn, $query_approved);
?>*/

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
        <title>Admin Approval Page</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 12px;
                border: 1px solid #ddd;
            }

            th {
                background-color: #f4f4f4;
            }

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

        <h1>Users Awaiting Approval</h1>
        <table class = "table table-bordered mt-3">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Institusi</th>
                    <th>Email</th>
                    <th>No Telefon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result_pending as $row):  ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
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

        <h1>Approved Users</h1>
        <table>
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
                <?php foreach($result_approved as $row): ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['college_uni']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['no_phone']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="<?php echo htmlspecialchars($user['user_id']); ?>" data-college_uni="<?php echo htmlspecialchars($user['college_uni']); ?>" data-email="<?php echo htmlspecialchars($user['email']); ?>" data-phone="<?php echo htmlspecialchars($user['no_phone']); ?>">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

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
                            <div class="form-group">
                                <label for="editCollegeUni">Institusi</label>
                                <input type="text" class="form-control" name="college_uni" id="editCollegeUni" required>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" name="email" id="editEmail" required>
                            </div>
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

    </body>
</html>

<!--CREATE TABLE rejected_users (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(50)
);
-->

<!--
    CREATE TABLE requests (
        id INT AUTO_INCREMENT,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        college_uni VARCHAR(255) NOT NULL,
        no_phone VARCHAR(20) NOT NULL,
        nama_pegawai VARCHAR(255) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        PRIMARY KEY (id)
    );
-->