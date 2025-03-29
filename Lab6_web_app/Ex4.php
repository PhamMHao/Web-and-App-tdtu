<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'reset') {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$form_data = $_SESSION['form_data'] ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Exercises</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.submitForm = () => document.querySelector('form').submit();
            window.resetForm = () => window.location.href = 'Ex4.php?action=reset';
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3">
                <h5 class="text-center mb-3">User Information</h5>
                <form action="result.php" method="POST">
                    <input type="hidden" name="action" value="submit">
                    <input type="hidden" name="back" value="1">
                    <div class="form-group">
                        <label for="name">Your name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Your name" value="<?php echo htmlspecialchars($form_data['name'] ?? '', ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Your email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Your email" value="<?php echo htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <legend class="col-form-label">Gender</legend>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" class="custom-control-input" id="male" name="gender" value="Male" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Male') ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="male">Male</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <input type="radio" class="custom-control-input" id="female" name="gender" value="Female" <?php echo (isset($form_data['gender']) && $form_data['gender'] == 'Female') ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="female">Female</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <legend class="col-form-label">Favorite web browsers</legend>
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chrome" name="browsers[]" value="Google Chrome" <?php echo (isset($form_data['browsers']) && is_array($form_data['browsers']) && in_array('Google Chrome', $form_data['browsers'])) ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="chrome">Google Chrome</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="ff" name="browsers[]" value="Firefox" <?php echo (isset($form_data['browsers']) && is_array($form_data['browsers']) && in_array('Firefox', $form_data['browsers'])) ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="ff">Firefox</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="safari" name="browsers[]" value="Safari" <?php echo (isset($form_data['browsers']) && is_array($form_data['browsers']) && in_array('Safari', $form_data['browsers'])) ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="safari">Safari</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="edge" name="browsers[]" value="Edge" <?php echo (isset($form_data['browsers']) && is_array($form_data['browsers']) && in_array('Edge', $form_data['browsers'])) ? 'checked' : ''; ?>>
                            <label class="custom-control-label" for="edge">Edge</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <legend class="col-form-label">Preferred Operating System</legend>
                        <select name="os" class="custom-select">
                            <option value="Windows 10" <?php echo (isset($form_data['os']) && $form_data['os'] == 'Windows 10') ? 'selected' : ''; ?>>Windows 10</option>
                            <option value="macOS" <?php echo (isset($form_data['os']) && $form_data['os'] == 'macOS') ? 'selected' : ''; ?>>macOS</option>
                            <option value="Linux" <?php echo (isset($form_data['os']) && $form_data['os'] == 'Linux') ? 'selected' : ''; ?>>Linux</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary px-5 mr-2">Submit</button>
                    <button type="button" onclick="resetForm()" class="btn btn-outline-primary px-5">Reset</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>