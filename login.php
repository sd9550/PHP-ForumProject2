<?php
require 'database.php';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'SELECT * FROM users WHERE user_name = :username';
        $params = ['username' => $username];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $user = $stmt->fetch();

        if($user != null && password_verify($password, $hashedPassword)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_name'] = $username;
            session_start();
            header('Location: index.php');
        } else {
            $error = 'Invalid username or password!';
        }
        
    } catch (PDOException $e) {

    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Forum Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <style>
    div.grid-bg {
      background-color: #eeeee4;
      padding: 5px;
    }

    div#main-content {
      width: 85%;
      min-width: 400px;
      margin: 0 auto;
    }
    form.login-form {
        width: 500px;
        margin: 25px auto;
    }
    </style>
  </head>

  <body>
    <!-- start navbar -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark" aria-label="Third navbar example">
    <div class="container-fluid">
      <!--<a class="navbar-brand" href="#">Expand at sm</a>-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav me-auto mb-2 mb-sm-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php"><img src="images/forum-logo2.png" alt="logo" /></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
          <li class="nav-item">
            <?php
              if(isset($_SESSION['loggedin'])) {
                echo '<a class="nav-link" href="profile.php">Profile</a>';
              } else {
                echo '<a class="nav-link" href="login.php">Login</a>';
              }
            ?>
          </li>
        </ul>
        <form role="search" method="post" action="logout.php">
          <?php if(isset($_SESSION['loggedin'])): ?>
            <button type="submit" name="logoutBtn">Logout</button>
          <?php endif ?>
        </form>
      </div>
    </div>
  </nav><!-- end navbar -->

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