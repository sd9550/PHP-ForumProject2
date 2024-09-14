<?php
$postid = $_GET['id'] ?? null;

if(!$postid) {
    header('Location: index.php');
    exit;
}

// get and display post
$sql = 'SELECT * FROM posts WHERE post_id = :id';
$query = $pdo->prepare($sql);
$params = ['id' => $postid];
$query->execute($params);
$result = $query->fetch();
$totalReplies = $result['total_replies'];

// add a reply if logged in
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

// get and display replies
$sql = 'SELECT * FROM replies WHERE post_id = :id';
$query = $pdo->prepare($sql);
$params = ['id' => $postid];
$query->execute($params);
$replies = $query->fetchAll();

?>