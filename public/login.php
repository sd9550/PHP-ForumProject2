<?php
require '../database.php';
require '../helpers.php';
include basePath('views/login.view.php');
$pageTitle = 'Forum Website - Login';
require basePath('views/partials/head.php');


?>

<div id="main-content">


  <form class="login-form" method="post">
    <h1 class="h3 mb-3 fw-normal">Login</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="username" name="username" required>
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
      <label for="floatingPassword">Password</label>
    </div>

    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    <?= $error ?>
  </form>

</div>

  </body>
</html>