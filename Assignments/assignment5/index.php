<?php
require_once 'classes/Directories.php';

$message = '';
$link = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $folderName = $_POST['folderName'] ?? '';
    $fileContent = $_POST['fileContent'] ?? '';

    if (!preg_match('/^[a-zA-Z]+$/', $folderName)) {
        $message = "Folder name should contain only alphabetic characters.";
    } else {
        $directoryHandler = new Directories();
        $result = $directoryHandler->createDirectoryAndFile($folderName, $fileContent);

        if ($result['success']) {
            $message = "File and directory were created.";
            $link = "<a href='{$result['path']}' target='_blank'>Path where file is located</a>";
        } else {
            $message = $result['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File and Directory Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            font-weight: bold;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .link {
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>File and Directory Assignment</h2>
<p>Enter a folder name and the contents of a file. Folder names should contain alphabetic characters only.</p>

<?php if (!empty($message)) : ?>
    <p class="<?= strpos($message, 'created') !== false ? 'success' : 'message' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<?php if (!empty($link)) : ?>
    <p class="link"><?= $link ?></p>
<?php endif; ?>

<form method="post">
    <label for="folderName">Folder Name</label>
    <input type="text" id="folderName" name="folderName" required>

    <label for="fileContent">File Content</label>
    <textarea id="fileContent" name="fileContent" rows="5" required></textarea>

    <button type="submit">Submit</button>
</form>

</body>
</html>
