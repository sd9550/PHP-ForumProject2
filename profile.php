<?php
require 'database.php';

if(!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
} else {
    $sql = 'SELECT * from posts WHERE user_name = :username';
    $query = $pdo->prepare($sql);
    $params = ['username' => $_SESSION['user_name']];
    $query->execute($params);
    $posts = $query->fetchAll();

    $sql = 'SELECT * from replies WHERE user_name = :username';
    $query = $pdo->prepare($sql);
    $query->execute($params);
    $replies = $query->fetchAll();
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

<h1 class="h3 mb-3 fw-normal">Posts by <?= $_SESSION['user_name'] ?></h1>
<?php foreach ($posts as $post): ?>
    
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $post['post_id'] ?>"><?= $post['title'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $post['user_name'] . ' | ' . $post['created_at'] ?> <a href="delete_post.php?id=<?= $post['post_id'] ?>">DELETE</a></div>
  </div>
<?php endforeach ?>

<h1 class="h3 mb-3 fw-normal">Replies by <?= $_SESSION['user_name'] ?></h1>
<?php foreach ($replies as $reply): ?>
    
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $reply['post_id'] ?>"><?= $reply['body'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $reply['user_name'] . ' | ' . $reply['created_at'] ?> <a href="delete_reply.php?id=<?= $post['post_id'] ?>">DELETE</a></div>
  </div>
<?php endforeach ?>

</div>

  </body>
</html>