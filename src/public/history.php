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

// ユーザーのブックマークを取得
$stmt = $pdo->prepare(
    'SELECT contact_id FROM bookmarks WHERE user_id = :user_id'
);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$bookmarks = $stmt->fetchAll(PDO::FETCH_COLUMN);

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-4">送信履歴</h1>
    <?php if (empty($contacts)): ?>
        <p>送信履歴はありません。</p>
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
                        <td class="border px-4 py-2"><?= htmlspecialchars(
                            $contact['title']
                        ) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars(
                            $contact['email']
                        ) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars(
                            $contact['content']
                        ) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars(
                            $contact['created_at']
                        ) ?></td>
                        <td class="border px-4 py-2">
                            <?php if (in_array($contact['id'], $bookmarks)): ?>
                                <a href="toggle_bookmark.php?contact_id=<?= $contact[
                                    'id'
                                ] ?>&action=remove" class="text-yellow-500 hover:text-yellow-600">★</a>
                            <?php else: ?>
                                <a href="toggle_bookmark.php?contact_id=<?= $contact[
                                    'id'
                                ] ?>&action=add" class="text-gray-400 hover:text-yellow-500">☆</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <div class="mt-4">
        <a href="index.php" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">送信画面へ戻る</a>
        <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ml-2">ログアウト</a>
        <a href="bookmarked_history.php" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded ml-2">ブックマークした履歴</a>
    </div>
</body>
</html>