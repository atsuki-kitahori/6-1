<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$contact_id = $_GET['contact_id'] ?? null;
$action = $_GET['action'] ?? null;

if (!$contact_id || !$action) {
    header('Location: history.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=contactform; charset=utf8mb4',
    $dbUserName,
    $dbPassword
);

if ($action === 'add') {
    $stmt = $pdo->prepare(
        'INSERT IGNORE INTO bookmarks (user_id, contact_id) VALUES (:user_id, :contact_id)'
    );
} elseif ($action === 'remove') {
    $stmt = $pdo->prepare(
        'DELETE FROM bookmarks WHERE user_id = :user_id AND contact_id = :contact_id'
    );
} else {
    header('Location: history.php');
    exit();
}

$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':contact_id', $contact_id, PDO::PARAM_INT);
$stmt->execute();

$referer = $_SERVER['HTTP_REFERER'] ?? 'history.php';
header('Location: ' . $referer);
