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

// SQLクエリの準備と実行
$stmt = $pdo->query('SELECT * FROM contacts ORDER BY created_at DESC');
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CSVヘッダーの設定
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="contacts_history.csv"');

// 出力バッファを開始
ob_start();

// CSVファイルを作成
$output = fopen('php://output', 'w');

// BOMを出力（Excelで開いたときに文字化けしないようにするため）
fputs($output, "\xEF\xBB\xBF");

// ヘッダー行を書き込む
fputcsv($output, ['ID', 'タイトル', 'メールアドレス', '内容', '送信日時']);

// データを書き込む
foreach ($contacts as $contact) {
    fputcsv($output, [
        $contact['id'],
        $contact['title'],
        $contact['email'],
        $contact['content'],
        $contact['created_at']
    ]);
}

// 出力バッファをフラッシュしてからファイルポインタを閉じる
ob_end_flush();
fclose($output);
exit();
