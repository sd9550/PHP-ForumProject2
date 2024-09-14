<?php
require '../database.php';
require '../helpers.php';
include basePath('views/home.view.php');
$pageTitle = 'Forum Website - Home';
require basePath('views/partials/head.php');
?>

<div id="main-content">

<?php foreach ($results as $result): ?>
  <div class="row mb-3 text-left">
  <div class="col-md-8 themed-grid-col grid-bg"><a href="post.php?id=<?= $result['post_id'] ?>"><?= $result['title'] ?></a></div>
  <div class="col-md-4 themed-grid-col grid-bg"><?= $result['user_name'] . ' | ' . $result['created_at'] . ' | ' . $result['total_replies'] ?>
<img src="images/replies.png" alt="total replies image"/></div>
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