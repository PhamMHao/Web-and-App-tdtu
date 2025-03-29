<!DOCTYPE html>
<html>
<head>
    <title>Simple Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Simple Calculator</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <!-- num1 -->
                            <div class="mb-3">
                                <input type="number" name="num1" class="form-control" placeholder="Enter first number">
                            </div>
                            <!-- num2 -->
                            <div class="mb-3">
                                <input type="number" name="num2" class="form-control" placeholder="Enter second number">
                            </div>
                            <!-- operator -->
                            <div class="mb-3 d-flex">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operator" id="add" value="+" checked>
                                    <label class="form-check-label" for="add">Cộng</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operator" id="subtract" value="-">
                                    <label class="form-check-label" for="subtract">Trừ</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operator" id="multiply" value="*">
                                    <label class="form-check-label" for="multiply">Nhân</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operator" id="divide" value="/">
                                    <label class="form-check-label" for="divide">Chia</label>
                                </div>
                            </div>
                           
                            <button type="submit" class="btn btn-primary w-100">Calculate</button>
                        </form>
                        
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $errors = [];
                            if (!isset($_POST['num1']) || $_POST['num1'] === '') {
                                $errors[] = "Số thứ nhất";
                            }
                            if (!isset($_POST['num2']) || $_POST['num2'] === '') {
                                $errors[] = "Số thứ hai";
                            }
                            if (empty($_POST['operator'])) {
                                $errors[] = "Phép toán";
                            }

                            if (!empty($errors)) {
                                echo "<div class='alert alert-danger mt-3'>Vui lòng nhập: " . implode(", ", $errors) . ".</div>";
                            } elseif ($_POST['num2'] == 0 && $_POST['operator'] == '/') {
                                echo "<div class='alert alert-danger mt-3'>Không thể chia cho 0.</div>";
                            } else {
                                $num1 = $_POST['num1'];
                                $num2 = $_POST['num2'];
                                $operator = $_POST['operator'];
                                $result = 0;

                                switch($operator) {
                                    case '+':
                                        $result = $num1 + $num2;
                                        break;
                                    case '-':
                                        $result = $num1 - $num2;
                                        break;
                                    case '*':
                                        $result = $num1 * $num2;
                                        break;
                                    case '/':
                                        $result = $num1 / $num2;
                                        break;
                                }

                                echo "<div class='alert alert-success mt-3'>Result: $num1 $operator $num2 = $result</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
