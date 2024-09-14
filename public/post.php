<?php
require '../database.php';
require '../helpers.php';
include basePath('views/post.view.php');
$pageTitle = 'Forum Website - Post ' . $postid;
require basePath('views/partials/head.php');
?>

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