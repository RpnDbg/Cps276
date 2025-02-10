<?php
// Step 1: Generate even numbers from 1 to 50
$evenNumbers = '';
foreach (range(1, 50) as $number) {
    if ($number % 2 == 0) {
        $evenNumbers .= $number . ' - ';
    }
}
$evenNumbers = rtrim($evenNumbers, ' - ');

// Step 2: Create a Bootstrap-styled form using a heredoc
$form = <<<FORM
<div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
</div>
<div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
</div>
FORM;

// Step 3: Create a function to generate a Bootstrap-styled table
function createTable($rows, $columns)
{
    $table = '<table class="table table-bordered">';
    for ($i = 1; $i <= $rows; $i++) {
        $table .= '<tr>';
        for ($j = 1; $j <= $columns; $j++) {
            $table .= "<td>Row $i, Col $j</td>";
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Webpage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <?php
        echo $evenNumbers;
        echo $form;
        echo createTable(8, 6);
    ?>
</body>
</html>
