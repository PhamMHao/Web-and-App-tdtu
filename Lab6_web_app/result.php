<?php
session_start();

const SAVE_FILE = 'information.txt';
const FORM_PAGE = 'Ex4.php';

function validateFormData($data) {
    return !empty($data['name']) && !empty($data['email']) && 
           !empty($data['gender']) && !empty($data['browsers']) && 
           !empty($data['os']);
}

function saveFormData($data) {
    $formattedData = sprintf(
        "Name: %s\nEmail: %s\nGender: %s\nFavorite Browsers: %s\nOperating System: %s\nDate: %s\n\n",
        $data['name'],
        $data['email'],
        $data['gender'],
        implode(", ", $data['browsers']),
        $data['os'],
        date('Y-m-d H:i:s')
    );
    
    return file_put_contents(SAVE_FILE, $formattedData, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'submit') {
        if (validateFormData($_POST)) {
            $_SESSION['form_data'] = $_POST;
        }
    } elseif ($_POST['action'] === 'save') {
        if (!empty($_SESSION['form_data'])) {
            saveFormData($_SESSION['form_data']);
            session_destroy();
            header('Location: ' . FORM_PAGE);
            exit;
        }
    }
}

$form_data = $_SESSION['form_data'] ?? [];
if (empty($form_data)) {
    header('Location: ' . FORM_PAGE);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        .user-input {
            color: #28a745;
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3">
                <h5 class="text-center mb-3">Submitted Information</h5>
                <div class="mb-3">
                    <strong>Name:</strong> <span class="user-input"><?php echo htmlspecialchars($form_data['name'] ?? '', ENT_QUOTES); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> <span class="user-input"><?php echo htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Gender:</strong> <span class="user-input"><?php echo htmlspecialchars($form_data['gender'] ?? '', ENT_QUOTES); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Favorite Browsers:</strong><br>
                    <?php
                    if (!empty($form_data['browsers'])) {
                        echo '<ul class="mb-0 user-input">';
                        foreach ($form_data['browsers'] as $browser) {
                            echo '<li>' . htmlspecialchars($browser, ENT_QUOTES) . '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
                
                <div class="mb-3">
                    <strong>Operating System:</strong> <span class="user-input"><?php echo htmlspecialchars($form_data['os'] ?? '', ENT_QUOTES); ?></span>
                </div>
                <div class="no-print">
                    <a href="Ex4.php" class="btn btn-primary px-5">Back</a>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="action" value="save">
                        <button type="submit" class="btn btn-success px-5">Save</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
