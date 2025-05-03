<?php


require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';


$pdo      = new Pdo_methods();
$contacts = $pdo->selectNotBinded(
    "SELECT id, fname, lname, address, city, state, phone, email, dob, contacts, age
       FROM contacts"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Delete Contact(s)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <h1>Delete Contact(s)</h1>

    <form method="post" action="index.php?page=deleteContacts">
      <?php if (empty($contacts)): ?>
        <p>No contacts found.</p>
      <?php else: ?>
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Phone</th>
              <th>Email</th>
              <th>DOB</th>
              <th>Contact</th>
              <th>Age</th>
              <th class="text-center">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($contacts as $c): ?>
              <tr>
                <td><?= htmlspecialchars($c['fname']) ?></td>
                <td><?= htmlspecialchars($c['lname']) ?></td>
                <td><?= htmlspecialchars($c['address']) ?></td>
                <td><?= htmlspecialchars($c['city']) ?></td>
                <td><?= htmlspecialchars($c['state']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['dob']) ?></td>
                <td><?= htmlspecialchars($c['contacts']) ?></td>
                <td><?= htmlspecialchars($c['age']) ?></td>
                <td class="text-center">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      name="ids[]"
                      value="<?= (int)$c['id'] ?>"
                      id="ct<?= (int)$c['id'] ?>">
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <button type="submit" class="btn btn-danger">
          Delete Selected
        </button>
      <?php endif; ?>
    </form>
  </div>

</body>
</html>
