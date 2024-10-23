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

    // Retrieve applicant and internship IDs from the database
    $application_id = $_GET['application_id'];
    $internship_id = $_GET['internship_id'];

    // Check if the applicant has already appealed
    $query = "SELECT * FROM appeals WHERE application_id = '$application_id' AND internship_id = '$internship_id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0)
    {
        echo "You have already appealed for this internship.";
        exit;
    }

    // Process the appeal application
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $appeal_reason = $_POST['appeal_reason'];

        // Insert the appeal into the database
        $query = "INSERT INTO appeals (application_id, internship_id, appeal_reason) VALUES ('$applicant_id', '$internship_id', '$appeal_reason')";
        if ($conn->query($query) === TRUE) {
            echo "Appeal submitted successfully.";
        } else {
            echo "Error submitting appeal: " . $conn->error;
        }

        // Notify the admin
        $admin_email = "admin@example.com"; // Replace with the admin's email
        $subject = "New Appeal Application";
        $message = "A new appeal application has been submitted by applicant #$application_id for internship #$internship_id.";
        mail($admin_email, $subject, $message);

        exit;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Appeal Application</title>
        
        <style>
            body
            {
                font-family: Arial, sans-serif;
                margin: 20px;
            }

            h1
            {
                color: #333;
                margin-bottom: 10px;
            }

            form
            {
                margin-top: 20px;
            }

            label
            {
                display: block;
                margin-bottom: 10px;
            }

            textarea
            {
                width: 100%;
                height: 150px;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
            }

            input[type="submit"]
            {
                background-color: #4CAF50;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            input[type="submit"]:hover
            {
                background-color: #3e8e41;
            }
        </style>
    </head>

    <body>
        <h1>Appeal Application</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="appeal_reason">Reason for Appeal:</label>
            <textarea id="appeal_reason" name="appeal_reason" required></textarea>
            <input type="hidden" name="applicant_id" value="<?php echo $applicant_id; ?>">
            <input type="hidden" name="internship_id" value="<?php echo $internship_id; ?>">
            <input type="submit" value="Submit Appeal">
        </form>

        <script src="script.js"></script>
    </body>
</html>