<?php


require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';


$pdo    = new Pdo_methods();
$admins = $pdo->selectNotBinded(
  "SELECT id, name, email, password, status
     FROM admins"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Delete Admin(s)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <h1>Delete Admin(s)</h1>

    <form method="post" action="index.php?page=deleteAdmins">
      <?php if (empty($admins)): ?>
        <p>No admins found.</p>
      <?php else: ?>
        <button type="submit" class="btn btn-danger mb-3">Delete</button>
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Password</th>
              <th>Status</th>
              <th class="text-center">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($admins as $a): 
         
              $parts = explode(' ', trim($a['name']), 2);
              $first = $parts[0];
              $last  = $parts[1] ?? '';
            ?>
              <tr>
                <td><?= htmlspecialchars($first) ?></td>
                <td><?= htmlspecialchars($last)  ?></td>
                <td><?= htmlspecialchars($a['email'])    ?></td>
                <td><code><?= htmlspecialchars($a['password']) ?></code></td>
                <td><?= htmlspecialchars($a['status'])   ?></td>
                <td class="text-center">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      name="ids[]"
                      value="<?= (int)$a['id'] ?>"
                      id="adm<?= (int)$a['id'] ?>">
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
