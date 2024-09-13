<?php
require 'database.php';

$postid = $_GET['id'] ?? null;

if(!$postid) {
    header('Location: index.php');
    exit;
}

$sql = 'SELECT * FROM posts WHERE post_id = :id';
$query = $pdo->prepare($sql);
$params = ['id' => $postid];
$query->execute($params);
$result = $query->fetch();
$totalReplies = $result['total_replies'];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['replyButton'])) {
    $reply = htmlspecialchars($_POST['message']);
    $username = $_SESSION['user_name'];
    $sql = 'INSERT INTO replies (post_id, user_name, body) VALUES (:postid, :username, :reply)';
    $stmt = $pdo->prepare($sql);
    $replyParams = ['postid' => $postid, 'username' => $username, 'reply' => $reply];
    $stmt->execute($replyParams);

    $currentTime = date("Y-m-d H:i:s");
    $updatedReplies = $totalReplies + 1;
    $sql = 'UPDATE posts SET last_reply = :currentTime, total_replies = :totalReplies WHERE post_id = :postid';
    $stmt = $pdo->prepare($sql);
    $timeParams = ['currentTime' => $currentTime, 'totalReplies' => $updatedReplies, 'postid' => $postid];
    $stmt->execute($timeParams);
}

$sql = 'SELECT * FROM replies WHERE post_id = :id';
$query = $pdo->prepare($sql);
$params = ['id' => $postid];
$query->execute($params);
$replies = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Forum Website - Post <?= $postid ?></title>
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

    form.reply-form {
        width: 500px;
        margin: 0 auto;
    }

    button.btn-bg {
        background-color: black;
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

<div class="row mb-3 text-left">
  <div class="col-md-12 themed-grid-col grid-bg"><?= $result['title'] . ' | ' . $result['user_name'] . ' | ' . $result['created_at'] ?></div>
</div>

<div class="row mb-3 text-left">
  <div class="col-md-12 themed-grid-col grid-bg"><?= $result['body'] ?></div>
</div>

<?php foreach($replies as $reply): ?>
    <br /><div class="row mb-3 text-left">
  <div class="col-md-12 themed-grid-col grid-bg"><?= $reply['user_name'] . ' | ' . $reply['created_at'] ?></div>
    </div>

    <div class="row mb-3 text-left">
  <div class="col-md-12 themed-grid-col grid-bg"><?= $reply['body'] ?></div>
</div>
<?php endforeach ?>

<?php if(isset($_SESSION['loggedin'])): ?>
<form class="reply-form" method="post">
    <h1 class="h3 mb-3 fw-normal">Reply to this post</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="message" name="message" required>
      <label for="floatingInput">Message</label>
    </div>

    <button class="btn btn-primary w-100 py-2 btn-bg" type="submit" name="replyButton">Reply</button>
  </form>
<?php endif ?>

</div>

  </body>
</html>