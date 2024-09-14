<?php
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