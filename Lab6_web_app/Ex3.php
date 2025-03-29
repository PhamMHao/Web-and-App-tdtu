<?php

$commentsFile = 'comments.txt';

// Set timezone to Vietnam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['comment'], $_POST['type'])) {
        $name = htmlspecialchars($_POST['name']);
        $comment = htmlspecialchars($_POST['comment']);
        $type = htmlspecialchars($_POST['type']);
        $timestamp = date('H:i - d/m/Y');

        $newComment = json_encode(['name' => $name, 'comment' => $comment, 'type' => $type, 'timestamp' => $timestamp]) . PHP_EOL;
        file_put_contents($commentsFile, $newComment, FILE_APPEND);
    }
}

// Handle comment deletion
if (isset($_GET['delete'])) {
    $deleteIndex = (int)$_GET['delete'];
    $comments = file($commentsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (isset($comments[$deleteIndex])) {
        unset($comments[$deleteIndex]);
        file_put_contents($commentsFile, implode(PHP_EOL, $comments) . PHP_EOL);
    }
    // after deleting comments, redirect to the same page to prevent form resubmission
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}


$comments = file_exists($commentsFile) ? file($commentsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
// $comments = array_reverse($comments); // Display latest comments first
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>PHP Exercises</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-8 my-3 mx-auto p-3">
                <div class="border rounded p-3">
                    <h4 class="text-center mb-3">Nhập bình luận của bạn</h4>
                    <form method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Họ và tên</label>
                                <input id="name" name="name" type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Chọn màu nền</label>
                                <select id="type" name="type" class="custom-select">
                                    <option value="alert-secondary" selected>Gray</option>
                                    <option value="alert-success">Green</option>
                                    <option value="alert-primary">Blue</option>
                                    <option value="alert-danger">Red</option>
                                    <option value="alert-warning">Yellow</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comment">Bình luận</label>
                            <textarea id="comment" name="comment" class="form-control" placeholder="Nhập nội dung" style="height: 80px"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                </div>
                <div class="mt-3" style="max-height: 300px; overflow: scroll">
                    <?php foreach ($comments as $index => $commentData): ?>
                        <?php $comment = json_decode($commentData, true); ?>
                        <div class="alert <?= $comment['type'] ?> alert-dismissible">
                            <a href="?delete=<?= $index ?>" class="close">&times;</a>
                            <strong><?= $comment['name'] ?>:</strong> <?= $comment['comment'] ?>
                            <div class="text-right small"><?= $comment['timestamp'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>