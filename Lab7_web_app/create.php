<?php
session_start();
if (!isset($_SESSION['login']))
    header('Location: login.php');

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

if (isset($_POST['filename']) && isset($_POST['content'])) {
    $filename = 'uploads/' . $_POST['filename'];
    file_put_contents($filename, $_POST['content']);
    header('Location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
            margin-top: 40px;
        }

        .card {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Create New File</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="filename" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="filename" name="filename" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">File Content</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Create File</button>
                        <a href="home.php" class="btn btn-secondary">Back to Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>