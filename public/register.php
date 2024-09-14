<?php
require '../database.php';
require '../helpers.php';
include basePath('views/register.view.php');
$pageTitle = 'Forum Website - Register';
require basePath('views/partials/head.php');

?>

<div id="main-content">

  <form class="register-form" method="post">
    <h1 class="h3 mb-3 fw-normal">Register</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="username" name="username" minlength="6" maxlength="12" required>
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" minlength="6" maxlength="10" required>
      <label for="floatingPassword">Password</label>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">Register</button>
    <?= $error ?><?= $validation ?>
  </form>

</div>

  </body>
</html>