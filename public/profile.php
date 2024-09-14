<?php
require '../database.php';
require '../helpers.php';
include basePath('views/profile.view.php');
$pageTitle = 'Forum Website - Profile';
require basePath('views/partials/head.php');
?>

<div id="main-content">

<h1 class="h3 mb-3 fw-normal">Posts by <?= $_SESSION['user_name'] ?></h1>
<?php foreach ($posts as $post): ?>
    
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $post['post_id'] ?>"><?= $post['title'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $post['user_name'] . ' | ' . $post['created_at'] ?> <a href="../delete_post.php?id=<?= $post['post_id'] ?>">DELETE</a></div>
  </div>
<?php endforeach ?>

<h1 class="h3 mb-3 fw-normal">Replies by <?= $_SESSION['user_name'] ?></h1>
<?php foreach ($replies as $reply): ?>
    
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $reply['post_id'] ?>"><?= $reply['body'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $reply['user_name'] . ' | ' . $reply['created_at'] ?> <a href="../delete_reply.php?id=<?= $post['post_id'] ?>">DELETE</a></div>
  </div>
<?php endforeach ?>

</div>

  </body>
</html>