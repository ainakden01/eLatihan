<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "intern";
$port = "3307";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, port: $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the status from the URL parameters
$status = $_GET['status'];

// Prepare SQL query based on the status
$query = "SELECT * FROM users";

if ($status !== 'all') {
    $query .= " WHERE status = '$status'";
}

// Execute the query
$result = $conn->query($query);

// Display the results in a table
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>No.</th><th>Institusi</th><th>Email</th><th>No Telefon</th></tr>";
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $row["college_uni"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["no_phone"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No applicants found for this status.";
}

// Close the connection
$conn->close();
?>