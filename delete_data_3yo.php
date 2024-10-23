<?php
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "intern";
    $port = "3307";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, port: $port);

    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to delete applicants whose internship end date is more than 3 years old
    $query = "DELETE FROM intership_applications WHERE end_date < DATE_SUB(CURDATE(), INTERVAL 3 YEAR)";

    // Execute query
    if ($conn->query($query) === TRUE)
    {
        echo "Records deleted successfully";
    }
    else
    {
        echo "Error deleting records: " . $conn->error;
    }

    $conn->close();
?>

    <!-- To schedule this script to run automatically,
    you'll need to set up a cron job on your server.
    The cron job will execute the PHP script at
    regular intervals (e.g., daily, weekly, etc.).
    You can use a cron job scheduler like 'contab' on Linux
    or 'Task Scheduler' on Windows to set this up

        Windows:

        1. Open the Task Scheduler: You can search for it in the Start
            menu, or type 'taskschd.msc' in the Run dialog box (Window key + R)
        2. Create a new task: Click on "Create Basic Task"
            in the right-hand Actions panel.
        3. Give the task a name and description: Enter a name and description
            for the task, such as "Delete old internship applicants".
        4. Set the trigger: Click on the "Triggers" tab and then click on
            "New". Select "Daily" or "Weekly" depending on how often you want
            the script to run. Set the start time and recurrence interval.
        5. Set the action: Click on the "Actions" tab and then click on "New".
            Select "Start a program" and enter the path to the PHP executable
            (usually 'C:\Path\To\php.exe'. In the "Add arguments" field,
            enter the path to your PHP script (e.g., 'C:\Path\To\script.php').
        6. Save the task: Click "OK" to save the task.
    
    make sure replace 'path/to/script.php' with the actual path to your PHP script.

    Important: Make sure the PHP executable is in the system's PATH environment variable,
                or provide the full path to the PHP executable in the task scheduler or crontab.

    Do you have any questions about setting up the task scheduler
    or would you like me to elaborate on any part of it? -->