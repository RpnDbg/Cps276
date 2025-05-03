<?php

require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/navigation.php';

$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);


$errors = $errors ?? [];
$vals   = $_POST    ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Admin</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body>
  <div class="container py-5">
    <h1 class="mb-4">Add Admin</h1>

    <?php if ($msg): ?>
      <div class="alert alert-<?= htmlspecialchars($msg['type']) ?>">
        <?= htmlspecialchars($msg['text']) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=addAdmin">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input
          type="text"
          name="name"
          class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''?>"
          value="<?= htmlspecialchars($vals['name'] ?? '') ?>"
        >
        <?php if (isset($errors['name'])): ?>
          <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input
          type="email"
          name="email"
          class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''?>"
          value="<?= htmlspecialchars($vals['email'] ?? '') ?>"
        >
        <?php if (isset($errors['email'])): ?>
          <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input
          type="password"
          name="password"
          class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''?>"
          value="<?= htmlspecialchars($vals['password'] ?? '') ?>"
        >
        <?php if (isset($errors['password'])): ?>
          <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select
          name="status"
          class="form-select <?= isset($errors['status']) ? 'is-invalid' : ''?>"
        >
          <option value="">-- select --</option>
          <option value="staff" <?= ( $vals['status'] ?? '' ) === 'staff' ? 'selected' : '' ?>>
            staff
          </option>
          <option value="admin" <?= ( $vals['status'] ?? '' ) === 'admin' ? 'selected' : '' ?>>
            admin
          </option>
        </select>
        <?php if (isset($errors['status'])): ?>
          <div class="invalid-feedback"><?= htmlspecialchars($errors['status']) ?></div>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-primary">Add Admin</button>
    </form>
  </div>
</body>
</html>
