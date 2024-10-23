<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Applicant Management</title>
        <style>
            /* Basic styling - customize as needed */
            body {
                font-family: sans-serif;
            }
            .container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }
            .button-group {
                display: flex;
                gap: 10px;
            }
            .button-group button {
                padding: 10px 20px;
                border: none;
                background-color: #4CAF50; /* Green */
                color: white;
                cursor: pointer;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                text-align: left;
                padding: 8px;
                border: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="button-group">
                <button id="allApplications">Jumlah Permohonan</button>
                <button id="acceptedApplications">Permohonan Berjaya</button>
                <button id="rejectedApplications">Permohonan Tidak Berjaya</button>
                <button id="pendingApplications">Permohonan Untuk Tindakan</button>
            </div>
        </div>

        <div id="applicantList">
            <!-- Applicant list will be loaded here -->
        </div>

        <script src="script.js"></script>
        <script>
            // Function to fetch applicants from the server and display them
            function fetchApplicants(status) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `fetch_applicants.php?status=${status}`, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = xhr.responseText;
                        document.getElementById('applicantList').innerHTML = response;
                    }
                };
                xhr.send();
            }

            // Add event listeners to the buttons
            document.getElementById('allApplications').addEventListener('click', function() {
                fetchApplicants('all');
            });

            document.getElementById('acceptedApplications').addEventListener('click', function() {
                fetchApplicants('accepted');
            });

            document.getElementById('rejectedApplications').addEventListener('click', function() {
                fetchApplicants('rejected');
            });

            document.getElementById('pendingApplications').addEventListener('click', function() {
                fetchApplicants('pending');
            });
        </script>
</body>
</html>