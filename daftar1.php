<?php
session_start();
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>e-Latihan Industri(Undang-Undang)</title>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/responsive.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <style>
        .container1 {
            width: 100%;
            max-width: 1200px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .row {
            display: flex;
            justify-content: center;
         }
        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: nowrap;   
        }
        .form-row label {
            width: 80px;
            margin-right: 10px;
        }
        .form-row input,
        .form-row select {
            flex: 1;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            min-width: 120px; 
            max-width: 100%; 
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
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .full_bg {
            background: url('images/banner2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
        }
        .main-layout {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.5); 
            }

            .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 400px; 
            text-align: center;
            border-radius: 10px;
            }

            .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            }

            .close:hover,
            .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
            }

    </style>
   
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
               <div class=" col-md-2 col-sm-3 col logo_section">
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
                              if (isset($_SESSION['college_uni'])) {
                                    echo "<span> Hi, " . htmlspecialchars($_SESSION['college_uni']) . "</span>";
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
                           <li class="nav-item">
                                    <a class="nav-link" href="search_rayuan.php">Rayuan</a>
                           </li>
                        </ul>
                     </div>
                  </nav>
               </div>
               <div class="col-md-2  d_none">
                  <ul class="email text_align_right">
                     <li><a href="logout.php">Logout
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- end header inner -->


<!-- ------------------------------------------------------------------------------------------------------------------------ -->


      <!-- top -->
      <div class="content-wrapper">
         <div class="full_bg">
            <div class="slider_main">
               <div class="container">
                  <div class="row">
                     <div class="container1">
                        <h2><b>Borang Permohonan Latihan Industri<b></h2><br>
                        <form method="post" action="proc_applications.php" enctype="multipart/form-data">
                           <div class="form-group">
                              <label for="start_date">Tarikh Mula</label>
                              <input type="date" class="form-control" id="start_date" name="start_date" required>
                           </div>
                           <div class="form-group">
                              <label for="end_date">Tarikh Tamat</label>
                              <input type="date" class="form-control" id="end_date" name="end_date" required>
                           </div>
                           <br>
                           <?php
                              try {
                                  $stmt = $pdo->prepare("SELECT id_negeri, negeri FROM tblnegeri ORDER BY negeri ASC");
                                  $stmt->execute();
                                  $states = $stmt->fetchAll(PDO::FETCH_ASSOC);
                              } catch (PDOException $e) {
                                  die('Database connection failed: ' . $e->getMessage());
                              }
                              ?>
                           <div class="form-row">
                              <label for="student_name">Nama Pelajar:</label>
                              <input type="text" name="students[]" autocomplete="off" placeholder="Nama Pelajar" required>
                              <label for="matrics">No. Matriks:</label>
                              <input type="text" name="matrics[]" autocomplete="off" placeholder="No Matriks" required>
                           </div>
                           <div class="form-row">
                              <label for="student_ic">No Pengenalan Diri:</label>
                              <input type="text" name="student_ic[]" autocomplete="off" placeholder="Kad Pengenalan Baru / Polis/ Tentera/ Pasport" required>
                              <label for="kursus">Kursus:</label>
                              <input type="text" name="kursus[]" autocomplete="off" placeholder="Kursus" required>
                           </div>
                           <div class="form-row">
                              <label for="id_negeri">Pilih Negeri:</label>
                              <select name="id_negeri[]" onchange="reload(this)" required>
                                 <option value="">Pilih Negeri</option>
                                 <?php foreach ($states as $state) : ?>
                                    <option value="<?php echo $state['id_negeri']; ?>"><?php echo htmlspecialchars($state['negeri']); ?></option>
                                 <?php endforeach; ?>
                              </select>

                              <label for="id_lokasi">Pilih Lokasi:</label>
                              <select name="id_lokasi[]" required>
                                 <option value="">Pilih Lokasi</option>
                              </select>
                           </div>
                              <!-- Dynamic Forms Container -->
                              <div id="dynamic-forms"></div>

                              <!-- Add Another Student Button -->
                              <button type="button" class="btn-add" onclick="addStudent()" title="Add another student">
                                 <i class="fas fa-plus"></i> Tambah Pelajar
                              </button>

                              <br><br><br>

                              <!-- Table to Display Students -->
                              <table class="table table-striped" id="student-table">
                                    <thead>
                                       <tr>
                                          <th>#</th> <!-- Numbering Column -->
                                          <th>Nama Pelajar</th>
                                          <th>No. Matriks</th>
                                          <th>No. Pengenalan Diri</th>
                                          <th>Kursus</th>
                                          <th>Negeri</th>
                                          <th>Lokasi</th>
                                          <th></th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                              </table>

                           <script>
                              let studentCount = 0;

                              function addStudent() {
                                 const studentName = document.querySelector('input[name="students[]"]').value;
                                 const matricNo = document.querySelector('input[name="matrics[]"]').value;
                                 const studentIC = document.querySelector('input[name="student_ic[]"]').value;
                                 const kursus = document.querySelector('input[name="kursus[]"]').value;

                                 const negeriSelect = document.querySelector('select[name="id_negeri[]"]');
                                 const negeri = negeriSelect.options[negeriSelect.selectedIndex].text;

                                 const lokasiSelect = document.querySelector('select[name="id_lokasi[]"]');
                                 const lokasi = lokasiSelect.options[lokasiSelect.selectedIndex].text;

                                 if (studentName && matricNo && studentIC && kursus && negeri && lokasi) {
                                    studentCount++;
                                    const tableBody = document.querySelector('#student-table tbody');
                                    const rowHTML = `
                                       <tr>
                                          <td>${studentCount}</td>
                                          <td>${studentName}</td>
                                          <td>${matricNo}</td>
                                          <td>${studentIC}</td>
                                          <td>${kursus}</td>
                                          <td>${negeri}</td>
                                          <td>${lokasi}</td>
                                          <td><button type="button" onclick="removeStudent(this)"><i class="fas fa-trash"></i></button></td>
                                          <td><button class="edit-btn" onclick="editRow(this)"><i class="fas fa-pencil-alt"></i></button></td>
                                       </tr>
                                    `;
                                    tableBody.insertAdjacentHTML('beforeend', rowHTML);

                                    document.querySelector('input[name="students[]"]').value = '';
                                    document.querySelector('input[name="matrics[]"]').value = '';
                                    document.querySelector('input[name="student_ic[]"]').value = '';
                                    document.querySelector('input[name="kursus[]"]').value = '';
                                    document.querySelector('select[name="id_negeri[]"]').value = '';
                                    document.querySelector('select[name="id_lokasi[]"]').value = '';
                                 } else {
                                    alert('Please fill all fields before adding.');
                                 }

                                 
                              }


                                 function removeStudent(button) {
                                    const row = button.closest('tr');
                                    row.remove();
                                    renumberTable();
                                 }

                                 function renumberTable() {
                                    const rows = document.querySelectorAll('#student-table tbody tr');
                                    rows.forEach((row, index) => {
                                       row.querySelector('td:first-child').textContent = index + 1;
                                    });
                                 }
                              function validateForm() {
                                    return true; 
                              }

                              function reload(selectElement) {
                              }

                              document.addEventListener('DOMContentLoaded', () => {
                              });
                           </script>
                           <br><br>

                              <!-- Borang Sokongan Upload -->
                              <div class="form-group">
                                 <label for="borang_sokongan">Borang Sokongan (PDF Only)</label>
                                 <input type="file" class="form-control" id="borang_sokongan" name="borang_sokongan" accept="application/pdf" required>
                              </div>
                              <!-- Submit Button -->
                              <input type="submit" class="btn-check" name="submit" value="Hantar">
                           </form>

                           <div id="successModal" class="modal">
                              <div class="modal-content">
                                 <div style="text-align: center;">
                                       <img src="images/uccess_icon.png" alt="Success" style="width:50px;height:50px;">
                                 </div>
                                 <h2>Berjaya!</h2>
                                 <p>Permohonan anda telah berjaya dihantar.</p>
                                 <p>ID Permohonan: <span id="applicationId"></span></p>
                                 <button onclick="window.location.href='report.php?application_id=' + document.getElementById('applicationId').textContent">Laporan Permohonan</button>
                              </div>
                           </div>


                        <script>
                           window.onload = function() {
                                 const urlParams = new URLSearchParams(window.location.search);
                                 if (urlParams.has('success') && urlParams.get('success') === 'true') {
                                    const applicationId = urlParams.get('application_id');
                                    document.getElementById('applicationId').innerText = applicationId;
                                    document.getElementById('successModal').style.display = 'block';
                                 }
                           };

                           function closeModal() {
                                 document.getElementById('successModal').style.display = 'none';
                           }
                        </script>

               
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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
                                            locationSelect.innerHTML = '<option value="">Select Location</option>';
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
         window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success') && urlParams.get('success') === 'true') {
               const applicationId = urlParams.get('application_id');
               document.getElementById('applicationId').innerText = applicationId;
               document.getElementById('successModal').style.display = 'block';
            }
         };

         function closeModal() {
            document.getElementById('successModal').style.display = 'none';
         }
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