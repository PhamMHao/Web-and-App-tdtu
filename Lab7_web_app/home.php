<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
if (isset($_FILES['file-upload'])) {
    $file = $_FILES['file-upload'];
    $filename = $file['name'];
    $file_size = $file['size'];
    $max_size = 20 * 1024 * 1024; // 20MB
    $allowed_types = array('txt', 'doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if ($file_size > $max_size) {
        echo "<div class='alert alert-danger' id='errorAlert'>File size must be less than 20MB</div>";
        echo "<script>
            setTimeout(() => {
                document.getElementById('errorAlert').style.display = 'none';
            }, 1500);
        </script>";
    } elseif (in_array($file_ext, ['exe', 'msi', 'sh'])) {
        echo "<div class='alert alert-danger' id = 'warning-error'>Executable files are not allowed</div>";
        echo "<script>
            setTimeout(() => {
                document.getElementById('warning-error').style.display = 'none';
            }, 1500);
        </script>";
    } else {
        move_uploaded_file($file['tmp_name'], 'uploads/' . $filename);
        echo "<div class='alert alert-success' id='successAlert'>Upload successful!</div>";
        echo "<script>
            setTimeout(() => {
                document.getElementById('successAlert').style.display = 'none';
            }, 1500);
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .fa,
        .fas {
            color: #858585;
        }

        .fa-folder {
            color: rgb(74, 158, 255);
        }

        i.fa,
        table i.fas {
            font-size: 16px;
            margin-right: 6px;
        }

        i.action {
            cursor: pointer;
        }

        a {
            color: black;
        }
    </style>

</head>

<body>
    <div class="container">

        <div class="row align-items-center py-5">
            <div class="col-6">
                <h3>File Manager</h3>
            </div>
            <div class="col-6">
                <h5 class="text-right">Xin chào <?php echo htmlspecialchars($_SESSION['username']); ?>, <a
                        class="text-primary" href="logout.php">Logout</a></h5>
            </div>
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Accessories</li>
        </ol>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fa fa-search"></span>
                </span>
            </div>
            <input type="text" class="form-control" placeholder="Search">
        </div>
        <div class="btn-group my-3">
            <a href="create_dir.php">
                <button type="button" class="btn btn-light border">
                    <i class="fas fa-folder-plus"></i> New folder
                </button>
            </a>

            <a href="create.php">
                <button type="button" class="btn btn-light border">
                    <i class="fas fa-file"></i> New file text
                </button>
            </a>

        </div>
        <table class="table table-hover border">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Last modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $files = scandir('uploads');
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $filepath = 'uploads/' . $file;
                        echo "<tr>";
                        if (is_dir($filepath)) {
                            echo "<td style='padding: 8px'>📁 $file</td>";
                            echo "<td style='padding: 8px'>Thư mục</td>";
                            echo "<td style='padding: 8px'>-</td>";
                        } else {
                            echo "<td style='padding: 8px'>📄 $file</td>";
                            echo "<td style='padding: 8px'>File</td>";
                            echo "<td style='padding: 8px'>" . number_format(filesize($filepath) / 1024, 2) . " KB</td>";
                        }
                        echo "<td style='padding: 8px'>" . date("d/m/Y H:i", filemtime($filepath)) . "</td>";
                        echo "<td style='padding: 8px'>";
                        if (is_dir($filepath)) {
                            echo "<a href='delete.php?file=$file&type=dir'><i class='fa fa-trash action'></i></a>  ";
                            echo "<a href='rename.php?file=$file&type=dir'><i class='fa fa-edit action'></i></a>";
                        } else {
                            echo "<a href='delete.php?file=$file'><i class='fa fa-trash action'></i></a>  ";
                            echo "<a href='rename.php?file=$file'><i class='fa fa-edit action'></i></a>  ";
                            echo "<a href='download.php?file=$file'><i class='fa fa-download action'></i></a>";

                        }
                        echo "</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="border rounded mb-3 mt-5 p-3">
            <h4>File upload</h4>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" name="file-upload">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <p>Người dùng chỉ được upload tập tin có kích thước tối đa là 20 MB.</p>
                <p>Các tập tin thực thi (*.exe, *.msi, *.sh) không được phép upload.</p>
                <input class="btn btn-success px-5" type="submit" value="Upload">
            </form>
        </div>
    </div>
    <script>
        document.getElementById('customFile').addEventListener('change', function () {
            var fileName = this.files[0].name;
            document.querySelector('.custom-file-label').textContent = fileName;
            document.getElementById('fileName').textContent = fileName;
            document.getElementById('fileInfo').style.display = 'block';
        });
    </script>
</body>

</html>