<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Display Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Display Notes</h1>
    <a href="addNote.php">Add Note</a>
    <form method="post">
        <?= $notes ?? '' ?>
        <div class="mb-3">
            <label for="begDate" class="form-label">Beginning Date</label>
            <input type="date" class="form-control" name="begDate">
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">Ending Date</label>
            <input type="date" class="form-control" name="endDate">
        </div>
        <button class="btn btn-primary" name="getNotes">Get Notes</button>
    </form>
</body>
</html>
