<?php
session_start();

$username_email = $_POST['username_email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username_email) || empty($password)) {
    $_SESSION['login_error'] =
        'ユーザー名/メールアドレスとパスワードを入力してください。';
    header('Location: login.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

$stmt = $pdo->prepare(
    'SELECT * FROM users WHERE username = :username_email OR email = :username_email'
);
$stmt->bindParam(':username_email', $username_email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    header('Location: index.php');
    exit();
} else {
    $_SESSION['login_error'] = 'ユーザー名またはパスワードが間違っています。';
    header('Location: login.php');
    exit();
}
