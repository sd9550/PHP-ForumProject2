<?php
session_start();
$host = 'localhost';
$port = 3306;
$dbName = 'forum-website';
$username = 'admin';
$pw = 'password1';

$dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $pw);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Database not connected!<br />';
    echo $e->getMessage();
}

?>