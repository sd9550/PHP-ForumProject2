<?php

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