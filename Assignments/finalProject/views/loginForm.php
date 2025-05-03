<?php
// When included from loginProc.php, $errors may contain messages.
// $vals holds any previously submitted values for stickiness.
$vals   = $_POST ?? [];
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="mb-4">Login</h1>

     
        <?php if (isset($errors['login'])): ?>
          <div class="alert alert-danger">
            <?= htmlspecialchars($errors['login']) ?>
          </div>
        <?php endif; ?>

        <form method="post" action="index.php?page=login">
       
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
              value="<?= htmlspecialchars($vals['email'] ?? 'rdabbaghian@admin.com') ?>"
            >
            <?php if (isset($errors['email'])): ?>
              <div class="invalid-feedback">
                <?= htmlspecialchars($errors['email']) ?>
              </div>
            <?php endif; ?>
          </div>

      
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
              value="<?= htmlspecialchars($vals['password'] ?? 'password') ?>"
            >
            <?php if (isset($errors['password'])): ?>
              <div class="invalid-feedback">
                <?= htmlspecialchars($errors['password']) ?>
              </div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary">Login</button>
        </form>

      </div>
    </div>
  </div>
</body>
</html>
