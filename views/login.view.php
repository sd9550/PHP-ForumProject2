<?php
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'SELECT * FROM users WHERE user_name = :username';
        $params = ['username' => $username];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $user = $stmt->fetch();

        if($user != null && password_verify($password, $hashedPassword)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_name'] = $username;
            session_start();
            header('Location: index.php');
        } else {
            $error = 'Invalid username or password!';
        }
        
    } catch (PDOException $e) {

    }
}
?>