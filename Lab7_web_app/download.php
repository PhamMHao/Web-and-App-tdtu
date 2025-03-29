<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = 'uploads/' . $file;

    if (file_exists($filepath)) {
        // Set headers
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($filepath));

        // Read and output file
        readfile($filepath);
        exit;
    } else {
        echo "File không tồn tại.";
        echo "<p><a href='list.php'>Back to List</a></p>";
    }
} else {
    header('Location: home.php');
}
?>