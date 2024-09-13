<?php
include 'database.php';

if(!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
} else {
    $sql = 'DELETE from posts WHERE post_id = :post_id';
    $query = $pdo->prepare($sql);
    $params = ['post_id' => $_GET['id']];
    $query->execute($params);

    header ('Location: profile.php');

}



?>