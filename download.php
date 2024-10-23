<?php
if (isset($_POST['file'])) {
    $file = urldecode($_POST['file']);
    $file_path = 'uploads/' . $file;

    if (file_exists($file_path)) {
        // Define headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        flush();
        readfile($file_path);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}
