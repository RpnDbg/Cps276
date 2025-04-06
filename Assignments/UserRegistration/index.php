<?php
require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';
require_once 'classes/StickyForm.php';
require_once 'classes/Validation.php';

$pdo = new PdoMethods();
$sticky = new StickyForm();
$valid = new Validation();

$errors = [];
$output = "";
$formData = ['first' => '', 'last' => '', 'email' => '', 'password' => '', 'confirm' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $formData = $_POST;

  // Validate
  if (!$valid->name($_POST['first'])) $errors['first'] = "Invalid first name.";
  if (!$valid->name($_POST['last'])) $errors['last'] = "Invalid last name.";
  if (!$valid->email($_POST['email'])) $errors['email'] = "Invalid email.";
  if (!$valid->password($_POST['password'])) $errors['password'] = "Password must be at least 8 chars, include 1 uppercase, 1 number, 1 symbol.";
  if ($_POST['password'] !== $_POST['confirm']) $errors['confirm'] = "Passwords do not match.";

  // Check if email already exists
  if (empty($errors)) {
    $sql = "SELECT email FROM users WHERE email = :email";
    $bindings = [[':email', $_POST['email'], 'str']];
    $result = $pdo->selectBinded($sql, $bindings);

    if ($result != 'error' && count($result) > 0) {
      $errors['email'] = "Email already exists.";
    }
  }

  // Insert user
  if (empty($errors)) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first, :last, :email, :password)";
    $bindings = [
      [':first', $_POST['first'], 'str'],
      [':last', $_POST['last'], 'str'],
      [':email', $_POST['email'], 'str'],
      [':password', $hash, 'str']
    ];
    $insert = $pdo->otherBinded($sql, $bindings);

    if ($insert === 'noerror') {
      $output = "You have been added to the database";
      $formData = ['first' => '', 'last' => '', 'email' => '', 'password' => '', 'confirm' => ''];
    } else {
      $output = "Database insert failed.";
    }
  }
}

// Display records
$records = $pdo->selectNotBinded("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-3">User Registration</h2>

    <?php if ($output): ?>
      <div class="alert alert-info"><?= $output ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">First Name</label>
          <input type="text" name="first" class="form-control" value="<?= $sticky->set($formData, 'first') ?>">
          <div class="text-danger"><?= $errors['first'] ?? '' ?></div>
        </div>
        <div class="col">
          <label class="form-label">Last Name</label>
          <input type="text" name="last" class="form-control" value="<?= $sticky->set($formData, 'last') ?>">
          <div class="text-danger"><?= $errors['last'] ?? '' ?></div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" name="email" class="form-control" value="<?= $sticky->set($formData, 'email') ?>">
        <div class="text-danger"><?= $errors['email'] ?? '' ?></div>
      </div>

      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control">
          <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
        </div>
        <div class="col">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirm" class="form-control">
          <div class="text-danger"><?= $errors['confirm'] ?? '' ?></div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary mb-4">Register</button>
    </form>

    <h4 class="mt-4">Users in Database</h4>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Password</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (is_array($records) && count($records) > 0) {
          foreach ($records as $row) {
            echo "<tr><td>{$row['first_name']}</td><td>{$row['last_name']}</td><td>{$row['email']}</td><td>{$row['password']}</td></tr>";
          }
        } else {
          echo '<tr><td colspan="4" class="text-center">No records to display.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
