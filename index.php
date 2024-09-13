<?php
include 'database.php';

$query = $pdo->prepare("SELECT * FROM posts ORDER BY last_reply DESC");
$query->execute();
$results = $query->fetchAll();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $topic = htmlspecialchars($_POST['topic']);
  $message = htmlspecialchars($_POST['message']);
  $currentTime = date("Y-m-d H:i:s");
  $totalReplies = 0;
  $sql = 'INSERT INTO posts (title, body, user_name, last_reply, total_replies) VALUES (:title, :message, :username, :last_reply, :total_replies)';
  $stmt = $pdo->prepare($sql);
  $params = ['title' => $topic, 'message' => $message, 'username' => $_SESSION['user_name'], 'last_reply' => $currentTime, 'total_replies' => $totalReplies];
  $stmt->execute($params);
  header ('Location: index.php');
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

<?php foreach ($results as $result): ?>
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $result['post_id'] ?>"><?= $result['title'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $result['user_name'] . ' | ' . $result['created_at'] . ' | ' . $result['total_replies'] ?></div>
  </div>
<?php endforeach ?>

<?php if(isset($_SESSION['loggedin'])): ?>
<form class="reply-form" method="post">
    <h1 class="h3 mb-3 fw-normal">Create new topic</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="topic" name="topic" required>
      <label for="floatingInput">Topic</label>
    </div>

    <div class="form-floating">
      <textarea rows="4" cols="25" class="form-control" id="floatingInput" placeholder="message" name="message" required>Message</textarea>
    </div>

    <button class="btn btn-primary w-100 py-2 btn-bg" type="submit" name="postButton">Post</button>
  </form>
<?php endif ?>

</div>

  </body>
</html>