<?php
require_once 'listFilesProc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded PDF Files</title>
</head>
<body>
    <h1>Uploaded PDF Files</h1>
    <?php echo $output; ?>
    <br><br>
    <a href="file_upload.php">Back to Upload Page</a>
</body>
</html>
