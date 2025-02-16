<?php
$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Names</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Add Names</h1>
    <form method="post" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Enter Name</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
        <button type="submit" name="add" class="btn btn-primary">Add Name</button>
        <button type="submit" name="clear" class="btn btn-primary">Clear Names</button>
        <div class="mt-3">
            <label for="namelist" class="form-label">List of Names</label>
            <textarea style="height: 500px;" class="form-control" id="namelist" name="namelist"><?php echo $output; ?></textarea>
        </div>
    </form>
</body>
</html>
