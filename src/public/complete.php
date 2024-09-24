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
}

// データベースに接続
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

if (empty($errors)) {
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

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <?php if (!empty($errors)): ?>
            <h1 class="text-2xl font-bold mb-4 text-red-500">エラー</h1>
            <ul class="list-disc list-inside mb-4">
                <?php foreach ($errors as $error): ?>
                    <li class="text-red-500"><?= htmlspecialchars(
                        $error
                    ) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="index.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block">送信画面へ戻る</a>
        <?php else: ?>
            <h1 class="text-2xl font-bold mb-4 text-green-500">送信完了</h1>
            <p class="mb-4">お問い合わせが正常に送信されました。</p>
            <div class="flex flex-col space-y-2">
                <a href="index.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center">送信画面へ</a>
                <a href="history.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-center">送信履歴へ</a>
                <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-center">ログアウト</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
