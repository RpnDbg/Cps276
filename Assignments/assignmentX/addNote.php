<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Add Note</h1>
    <a href="displayNotes.php">Display Notes</a>
    <form method="post">
        <?= $notes ?? '' ?>
        <div class="mb-3">
            <label for="dateTime" class="form-label">Date and Time</label>
            <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" name="note" rows="6"></textarea>
        </div>
        <button class="btn btn-primary" name="addNote">Add Note</button>
    </form>
</body>
</html>
