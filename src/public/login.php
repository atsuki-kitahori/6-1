<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4">ログイン</h1>
        <?php if (isset($_SESSION['login_error'])) {
            echo '<p class="text-red-500 mb-4">' .
                htmlspecialchars($_SESSION['login_error']) .
                '</p>';
            unset($_SESSION['login_error']);
        } ?>
        <form action="login_process.php" method="post">
            <div class="mb-4">
                <label for="username_email" class="block text-sm font-medium text-gray-700 mb-1">ユーザー名またはメールアドレス</label>
                <input type="text" id="username_email" name="username_email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300">
                ログイン
            </button>
        </form>
        <p class="mt-4 text-center">
            アカウントをお持ちでない方は<a href="register.php" class="text-indigo-500 hover:underline">こちら</a>から登録してください。
        </p>
    </div>
</body>
</html>
