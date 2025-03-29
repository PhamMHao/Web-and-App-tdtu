<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

$file = $_GET['file'];
$type = isset($_GET['type']) ? $_GET['type'] : 'file';

if ($type == 'dir') {
    rmdir("uploads/$file");
} else {
    unlink("uploads/$file");
}
header('Location: home.php');
?>