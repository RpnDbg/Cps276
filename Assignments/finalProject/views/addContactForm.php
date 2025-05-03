<?php

require_once __DIR__ . '/../includes/security.php';
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);
require_once __DIR__ . '/../classes/StickyForm.php';
require_once __DIR__ . '/../classes/Validation.php';

if (!isset($formConfig)) {
    $formConfig = [
        'fname'    => ['type'=>'text','name'=>'fname','id'=>'fname','label'=>'*First Name','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid first name','regex'=>'name'],
        'lname'    => ['type'=>'text','name'=>'lname','id'=>'lname','label'=>'*Last Name','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid last name','regex'=>'name'],
        'address'  => ['type'=>'text','name'=>'address','id'=>'address','label'=>'*Address','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid address','regex'=>'address'],
        'city'     => ['type'=>'text','name'=>'city','id'=>'city','label'=>'*City','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid city','regex'=>'name'],
        'state'    => ['type'=>'text','name'=>'state','id'=>'state','label'=>'*State','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid state','regex'=>'name'],
        'zip'      => ['type'=>'text','name'=>'zip','id'=>'zip','label'=>'*Zip Code','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a 5-digit ZIP','regex'=>'zip'],
        'phone'    => ['type'=>'text','name'=>'phone','id'=>'phone','label'=>'*Phone','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Use 10 digits or 123.456.7890','regex'=>'phone'],
        'email'    => ['type'=>'email','name'=>'email','id'=>'email','label'=>'*Email','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid email','regex'=>'email'],
     
        'dob'      => ['type'=>'text','name'=>'dob','id'=>'dob','label'=>'*DOB (MM/DD/YYYY)','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Enter a valid date','regex'=>'none'],
        'contacts' => [
            'type'=>'checkbox','name'=>'contacts','id'=>'contacts','label'=>'Contact Methods','required'=>false,'value'=>[],'error'=>'','errorMsg'=>'Select at least one','regex'=>'none',
            'options'=>[
                ['value'=>'Phone','label'=>'Phone'],
                ['value'=>'Email','label'=>'Email'],
                ['value'=>'Mail','label'=>'Mail'],
            ],
        ],
        'age' => [
            'type'=>'radio','name'=>'age','id'=>'age','label'=>'*Age Range','required'=>true,'value'=>'','error'=>'','errorMsg'=>'Select age range','regex'=>'none',
            'options'=>[
                ['value'=>'Under18','label'=>'Under 18'],
                ['value'=>'18-65','label'=>'18–65'],
                ['value'=>'65+','label'=>'65+'],
            ],
        ],
    ];
}
$sticky = new StickyForm($formConfig);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/../includes/navigation.php'; ?>
  <div class="container py-4">
    <h1>Add Contact</h1>
    <?php if (!empty($msg['text'])): ?>
      <div class="alert alert-<?= htmlspecialchars($msg['type']) ?>">
        <?= htmlspecialchars($msg['text']) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=addContact" novalidate>
      <div class="row mb-3">
        <div class="col-md-6"><?= $sticky->renderInput($formConfig['fname'], 'mb-3') ?></div>
        <div class="col-md-6"><?= $sticky->renderInput($formConfig['lname'], 'mb-3') ?></div>
      </div>
      <?= $sticky->renderInput($formConfig['address'], 'mb-3') ?>

      <div class="row mb-3">
        <div class="col-md-4"><?= $sticky->renderInput($formConfig['city'], 'mb-3') ?></div>
        <div class="col-md-4"><?= $sticky->renderInput($formConfig['state'], 'mb-3') ?></div>
        <div class="col-md-4"><?= $sticky->renderInput($formConfig['zip'], 'mb-3') ?></div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6"><?= $sticky->renderInput($formConfig['phone'], 'mb-3') ?></div>
        <div class="col-md-6"><?= $sticky->renderInput($formConfig['email'], 'mb-3') ?></div>
      </div>


      <div class="mb-3">
        <label for="dob" class="form-label"><?= $formConfig['dob']['label'] ?></label>
        <input
          type="text"
          class="form-control <?= $formConfig['dob']['error'] ? 'is-invalid' : '' ?>"
          id="dob"
          name="dob"
          placeholder="MM/DD/YYYY"
          pattern="\d{2}/\d{2}/\d{4}"
          value="<?= htmlspecialchars($formConfig['dob']['value']) ?>"
          oninput="formatDOB(this)"
          required
        >
        <?php if ($formConfig['dob']['error']): ?>
          <div class="invalid-feedback">
            <?= htmlspecialchars($formConfig['dob']['error']) ?>
          </div>
        <?php endif; ?>
      </div>

      <?= $sticky->renderCheckboxGroup($formConfig['contacts'], 'mb-3', 'horizontal') ?>
      <?= $sticky->renderRadio($formConfig['age'], 'mb-3', 'horizontal') ?>

      <button type="submit" class="btn btn-primary">Add Contact</button>
    </form>
  </div>

  <script>
    function formatDOB(el) {
      let v = el.value.replace(/\D/g,'').slice(0,8);
      if (v.length > 4) {
        v = v.replace(/^(\d{2})(\d{2})(\d{1,4})$/,'$1/$2/$3');
      } else if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d{1,2})$/,'$1/$2/');
      }
      el.value = v;
    }
  </script>
</body>
</html>
