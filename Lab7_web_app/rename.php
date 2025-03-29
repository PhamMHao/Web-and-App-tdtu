<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

if (isset($_POST['newname'])) {
    rename("uploads/" . $_GET['file'], "uploads/" . $_POST['newname']);
    header('Location: home.php');
}
?>
<form method="post">
    Tên mới cho file <?= $_GET['file'] ?>: <input type="text" name="newname">
    <input type="submit" value="Đổi tên">
</form>