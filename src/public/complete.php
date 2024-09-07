<?php
$title = $_POST['title'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

$errors = [];
if (empty($title)) {
    $errors[] = 'タイトルを入力してください。';
}
if (empty($email)) {
    $errors[] = 'メールアドレスを入力してください。';
}
if (empty($message)) {
    $errors[] = '内容を入力してください。';
}

if (!empty($errors)) {
    echo 'エラーがあります：<br>';
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . '<br>';
    }
} else {
    echo '<h1>送信完了！！！</h1>';
    echo 'お問い合わせありがとうございます。以下の内容で受け付けました：<br>';
    echo 'タイトル: ' . htmlspecialchars($title) . '<br>';
    echo 'Email: ' . htmlspecialchars($email) . '<br>';
    echo '内容: ' . htmlspecialchars($message) . '<br>';
}
?>
