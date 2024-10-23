<?php
// Connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
   
// Fetch and sanitize data from POST request
$studentCount = intval($_POST['rowId']);
$studentName = $conn->real_escape_string($_POST['name']);
$matricNO = $conn->real_escape_string($_POST['matrix']);
$studentIC = $conn->real_escape_string($_POST['id']);
$kursus = $conn->real_escape_string($_POST['course']);
$negeri = $conn->real_escape_string($_POST['state']);
$lokasi = $conn->real_escape_string($_POST['location']);

// Update the database with the new details
$sql = "UPDATE students_table SET name='$name', matrix='$matrix', id='$id', course='$course', state='$state', location='$location' WHERE id=$rowId";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
