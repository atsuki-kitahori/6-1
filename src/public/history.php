<?php
// データベースに接続
$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

// SQLクエリの準備と実行
$stmt = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC');
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信履歴</title>
</head>
<body>
    <h1>送信履歴</h1>
    <?php if (empty($contacts)): ?>
        <p>送信履歴はありません。</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>タイトル</th>
                <th>メールアドレス</th>
                <th>内容</th>
                <th>送信日時</th>
            </tr>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['title']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['content']) ?></td>
                    <td><?= htmlspecialchars($contact['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <br>
    <a href="index.php">送信画面へ戻る</a>
</body>
</html>