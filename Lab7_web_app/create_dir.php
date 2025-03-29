<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

$error = '';
if (isset($_POST['dirname'])) {
    $dirname = trim($_POST['dirname']);
    if (empty($dirname)) {
        $error = "Vui lòng nhập tên thư mục!";
    } else {
        $dirname = 'uploads/' . $dirname;
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
            header('Location: home.php');
        } else {
            $error = "Thư mục đã tồn tại!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Thư Mục Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="home.php">Quản Lý Tệp</a>
            <div class="navbar-nav">
                <a class="nav-link" href="home.php">Trang Chủ</a>
                <a class="nav-link active" href="create_dir.php">Tạo Thư Mục</a>
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">Tạo Thư Mục Mới</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="post" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="dirname" class="form-label">Tên thư mục mới</label>
                                <input type="text" class="form-control" id="dirname" name="dirname" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập tên thư mục
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tạo thư mục</button>
                            <a href="home.php" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>