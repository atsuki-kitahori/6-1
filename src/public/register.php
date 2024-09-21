<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-md p-8 max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4">ユーザー登録</h1>
        <form action="register_process.php" method="post">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">ユーザー名</label>
                <input type="text" id="username" name="username" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">パスワード</label>
                <input type="password" id="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300">
                登録
            </button>
        </form>
        <p class="mt-4 text-center">
            既にアカウントをお持ちの方は<a href="login.php" class="text-indigo-500 hover:underline">こちら</a>からログインしてください。
        </p>
    </div>
</body>
</html>