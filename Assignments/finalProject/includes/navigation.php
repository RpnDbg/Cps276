<?php
  $status = $_SESSION['user']['status'] ?? '';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">Final Project</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=addContact">Add Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=deleteContacts">Delete Contact(s)</a>
        </li>

        <?php if ($status === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=addAdmin">Add Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=deleteAdmins">Delete Admin(s)</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href="index.php?page=logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
