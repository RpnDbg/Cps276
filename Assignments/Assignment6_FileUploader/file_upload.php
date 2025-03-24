<?php
require_once 'fileUploadProc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload PDF File</title>
</head>
<body>
    <h1>Upload PDF File</h1>
    <form action="" method="post" enctype="multipart/form-data">
        File name (label): <input type="text" name="filename"><br><br>
        Select PDF file: <input type="file" name="pdf_file"><br><br>
        <input type="submit" name="submit" value="Upload PDF">
    </form>
    <p style="color:red;"><?php echo $output ?? ''; ?></p>
    <br>
    <a href="list_files.php">Show File List</a>
</body>
</html>
