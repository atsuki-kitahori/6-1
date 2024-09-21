<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$title = $_POST['title'] ?? '';
$email = $_POST['email'] ?? '';
$content = $_POST['content'] ?? '';

$errors = [];
if (empty($title) || empty($email) || empty($content)) {
    $errors = array_filter([
        empty($title) ? 'タイトルを入力してください。' : null,
        empty($email) ? 'メールアドレスを入力してください。' : null,
        empty($content) ? '内容を入力してください。' : null,
    ]);
    echo 'エラーがあります：<br>';
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
    echo '<br><a href="index.php">送信画面へ</a>';
    exit();
} else {
    echo '<h1>送信完了！！！</h1>';
    echo '<br><a href="index.php">送信画面へ</a><br>';
    echo '<a href="history.php">送信履歴へ</a>';
    echo '<a href="logout.php">ログアウト</a>';

    // データベースに接続
    $dbUserName = 'root';
    $dbPassword = 'password';
    $pdo = new PDO(
        'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
        $dbUserName,
        $dbPassword
    );

    // SQLクエリの準備
    $stmt = $pdo->prepare(
        'INSERT INTO contacts (title, email, content) VALUES (:title, :email, :content)'
    );

    // パラメータをバインド
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);

    // クエリを実行
    $res = $stmt->execute();
}

?>
