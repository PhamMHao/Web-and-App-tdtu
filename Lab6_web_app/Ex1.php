<!DOCTYPE html>
<html>
<head>
    <title>Multiplication Table</title>
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 20px;
        }
        td, th {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            margin: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="10">BẢNG CỬU CHƯƠNG</th>
        </tr>
        <?php
        for ($j = 1; $j <= 10; $j++) {
            echo "<tr>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<td>" . $i . " x " . $j . " =" . ($i * $j) . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
