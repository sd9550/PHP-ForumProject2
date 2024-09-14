<?php
$error = '';
$validation = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (user_name, password) VALUES (:username, :password)';
        $params = ['username' => $username, 'password' => $hashedPassword];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $validation = 'User ' . $username . ' was registered!';
    } catch (PDOException $e) {
        if($e->getCode() == 23000) {
            $error = 'That username already exists';
        } else {
            $error = 'An error has occured';
        }
    }

}?>