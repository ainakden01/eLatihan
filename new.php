<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
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
        /* Styles (same as in the original code) */
    </style>
</head>
<body>
    <!-- Sidebar and header (same as the original code) -->

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
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['college_uni']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['no_phone']); ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="<?php echo htmlspecialchars($user['user_id']); ?>" data-college_uni="<?php echo htmlspecialchars($user['college_uni']); ?>" data-email="<?php echo htmlspecialchars($user['email']); ?>" data-phone="<?php echo htmlspecialchars($user['no_phone']); ?>">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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

        document.getElementById("removeData").addEventListener("click", function() {
            const userId = document.getElementById("editUserId").value;

            if (confirm("Are you sure you want to delete this institute?")) {
                // Make an AJAX request to delete the institute
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_institute.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Institute deleted successfully.");
                        // Optionally, you can refresh the table or redirect the user
                        window.location.reload();
                    }
                };

                xhr.send("user_id=" + userId);
            }
        });
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];

        // Delete institute by user ID securely using prepared statements
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Institute deleted successfully";
        } else {
            echo "Error: Failed to delete institute.";
        }
    }
    ?>
</body>
</html>

<?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $userId = $_POST['user_id'];
        
            // Delete institute by user ID
            $sql = "DELETE FROM users WHERE id = '$user_id'";
            if ($conn->query($sql) === TRUE)
            {
                echo "Institute deleted successfully";
            }
            else
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
        $conn->close();
    ?>