<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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

// ブックマークされた履歴のみを取得
$stmt = $pdo->prepare('
    SELECT c.* 
    FROM contacts c
    INNER JOIN bookmarks b ON c.id = b.contact_id
    WHERE b.user_id = :user_id
    ORDER BY c.created_at DESC
');
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブックマークした履歴</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-4">ブックマークした履歴</h1>
    <?php if (empty($contacts)): ?>
        <p>ブックマークした履歴はありません。</p>
    <?php else: ?>
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">タイトル</th>
                    <th class="px-4 py-2">メールアドレス</th>
                    <th class="px-4 py-2">内容</th>
                    <th class="px-4 py-2">送信日時</th>
                    <th class="px-4 py-2">ブックマーク</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= htmlspecialchars($contact['title']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($contact['email']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($contact['content']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($contact['created_at']) ?></td>
                        <td class="border px-4 py-2">
                            <a href="toggle_bookmark.php?contact_id=<?= $contact['id'] ?>&action=remove" class="text-yellow-500 hover:text-yellow-600">★</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <div class="mt-4">
        <a href="history.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">全ての履歴を表示</a>
        <a href="index.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded ml-2">送信画面へ戻る</a>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-2">ログアウト</a>
    </div>
</body>
</html>
