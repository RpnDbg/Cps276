<?php

require_once __DIR__ . '/../includes/security.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body>


  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">

    <?php if ($_SESSION['user']['status'] === 'admin'): ?>

      <h1>Admin Dashboard</h1>
      <p class="lead">Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?></p>

    <?php else: ?>

      <h1>Welcome Page</h1>
      <p class="lead">Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?></p>

    <?php endif; ?>

  </div>
</body>
</html>
