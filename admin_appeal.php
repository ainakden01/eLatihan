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
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve all appeal applications
    $query = "SELECT * FROM appeal";
    $result = $conn->query($query);

    if ($result->num_rows > 0)
    {
        echo "<h1>Apeal Applications</h1>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Applicant ID</th><th>Internship ID</th><th>Reason</th><th>Status</th><th>Update</th></tr>";

        while($row = $result->fetch_assoc())
        {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["applicant_id"] . "</td>";
            echo "<td>" . $row["internship_id"] . "</td>";
            echo "<td>" . $row["appeal_reason"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td><a href='update_status.php?id=" . $row["id"] . "'>Update Status</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    else
    {
        echo "No appeal applications found.";
    }

    $conn->close();
?>