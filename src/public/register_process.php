<?php
session_start();

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($email) || empty($password)) {
    $_SESSION['error'] = '全ての項目を入力してください。';
    header('Location: register.php');
    exit();
}

// データベースに接続
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

// ユーザー名またはメールアドレスが既に存在するか確認
$stmt = $pdo->prepare(
    'SELECT * FROM users WHERE username = :username OR email = :email'
);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['error'] =
        'ユーザー名またはメールアドレスが既に使用されています。';
    header('Location: register.php');
    exit();
}

// パスワードをハッシュ化
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ユーザー情報をデータベースに保存
$stmt = $pdo->prepare(
    'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)'
);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashedPassword);
$stmt->execute();

if ($stmt->execute()) {
    $_SESSION['success'] = 'ユーザー登録が完了しました。ログインしてください。';
    header('Location: login.php');
} else {
    $_SESSION['error'] = 'ユーザー登録に失敗しました。もう一度お試しください。';
    header('Location: register.php');
}
exit();
