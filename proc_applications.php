<?php
session_start();
include 'db_connect.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $unique_id = time(); 
    $original_file_name = basename($_FILES["borang_sokongan"]["name"]);
    $target_file = $target_dir . $unique_id . "_" . $original_file_name;
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // File size validation
    if ($_FILES["borang_sokongan"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // File type validation
    $allowedFileTypes = array("pdf");
    if (!in_array($fileType, $allowedFileTypes)) {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }

    // File upload failure handling
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Upload file if validation passed
        if (move_uploaded_file($_FILES["borang_sokongan"]["tmp_name"], $target_file)) {
            try {
                // Start database transaction
                $pdo->beginTransaction(); 

                // Fetch the latest application ID for numbering
                $stmt = $pdo->query("SELECT MAX(application_id) AS max_id FROM internship_applications WHERE application_id LIKE 'LIUU-%'");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $max_id = $row['max_id'];

                // Generate new application ID
                if ($max_id) {
                    $last_number = (int) substr($max_id, 5); // LIUU-001 format
                    $next_number = $last_number + 1;
                    $next_application_id = "LIUU-" . str_pad($next_number, 3, '0', STR_PAD_LEFT);
                } else {
                    $next_application_id = "LIUU-001";
                }

                // Insert into internship_applications table
                $borang_sokongan = $unique_id . "_" . $original_file_name;
                $start_date = htmlspecialchars($_POST['start_date']);
                $end_date = htmlspecialchars($_POST['end_date']);
                $user_id = $_SESSION['user_id'];

                $stmt = $pdo->prepare("INSERT INTO internship_applications (application_id, borang_sokongan, start_date, end_date, user_id) 
                                        VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$next_application_id, $borang_sokongan, $start_date, $end_date, $user_id]);

                // Process student data
                if (isset($_POST['students'])) {
                    $student_count = count($_POST['students']);
                    for ($i = 0; $i < $student_count; $i++) {
                        // Validate each student's input
                        $student_name = htmlspecialchars(trim($_POST['students'][$i]));
                        $student_matrics = htmlspecialchars(trim($_POST['matrics'][$i]));
                        $student_ic = htmlspecialchars(trim($_POST['student_ic'][$i]));
                        $kursus = htmlspecialchars(trim($_POST['kursus'][$i]));
                        $id_negeri = htmlspecialchars(trim($_POST['id_negeri'][$i]));
                        $id_lokasi = htmlspecialchars(trim($_POST['id_lokasi'][$i]));
                        $country = htmlspecialchars(trim($_POST['country'][$i]));

                        // Check for empty values
                        if (empty($student_name) || empty($student_matrics) || empty($student_ic) || empty($kursus) || empty($id_negeri) || empty($id_lokasi) || empty($country)) {
                            // Handle empty values (e.g., redirect with error message)
                            header("Location: daftar1.php?error=empty_values");
                            exit();
                        }

                        // Debugging: Print the values being inserted
                        echo "Inserting student $i: $student_name, $student_matrics, $student_ic, $kursus, $id_negeri, $id_lokasi, $country\n";

                        $stmt = $pdo->prepare("INSERT INTO students (student_name, student_matrics, student_ic, kursus, negeri_id, lokasi_id, application_id, country) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([
                            $student_name,
                            $student_matrics,
                            $student_ic,
                            $kursus,
                            $id_negeri,
                            $id_lokasi,
                            $next_application_id,
                            $country
                        ]);
                    }
                }

                // Commit transaction
                $pdo->commit(); 

                // Redirect with success message
                header("Location: daftar1.php?success=true&application_id=" . $next_application_id);
                exit();
            } catch (PDOException $e) {
                // Rollback transaction on failure
                $pdo->rollBack(); 
                die('Database connection failed: ' . $e->getMessage());
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>