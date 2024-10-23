<style>
        .container1 {
            width: 100%;
            max-width: 100%;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            position: relative;
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
            max-width: 180px; 
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

         <!-- top -->
         <div class="content-wrapper">
         <div class="full_bg">
            <div class="slider_main">
               <div class="container">
                  <div class="row">
                     <div class="container1">
                        <h2><b>Borang Latihan Industri<b></h2><br>
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
                              <label>Pelajar:</label>
                              <input type="text" name="students[]" placeholder="Nama Pelajar" required autocomplete=off>
                              <input type="text" name="matrics[]" placeholder="No. Matriks" required autocomplete=off>
                              <input type="text" name="student_ic[]" placeholder="No. Kad Pengenalan" required>
                              <input type="text" name="kursus[]" placeholder="Kursus" required>
                              <!-- State Dropdown -->
                              <select name="id_negeri[]" onchange="reload(this)">
                                 <option value="">Pilih Negeri</option>
                                 <?php foreach ($states as $state) : ?>
                                 <option value="<?php echo $state['id_negeri']; ?>"><?php echo htmlspecialchars($state['negeri']); ?></option>
                                 <?php endforeach; ?>
                              </select>
                              <!-- End State Dropdown -->
                              <select name="id_lokasi[]">
                                 <option value="">Pilih Lokasi</option>
                              </select>
                              <button type="button" class="btn-delete" onclick="deleteForm(this)" title="Remove this student">
                              <i class="fas fa-trash"></i>
                              </button>
                           </div>
                           <div id="dynamic-forms"></div>
                           <button type="button" class="btn-add" onclick="addForm()" title="Add another student">
                           <i class="fas fa-plus"></i> Tambah Pelajar
                           </button>
                           <br><br>
                           <label for="borang_sokongan">Borang Sokongan:</label>
                           <input type="file" name="borang_sokongan" id="borang_sokongan" required>
                           <br>
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