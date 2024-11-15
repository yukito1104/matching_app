<?php
// registar.php
session_start();
require 'config.php'; // データベース接続

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        // ユーザーが正常に作成された場合、自動でログインさせる
        $new_user_id = $stmt->insert_id; // 作成したユーザーのIDを取得
        $_SESSION['user_id'] = $new_user_id; // セッションにユーザーIDを保存してログイン状態にする

        // menu.php にリダイレクト
        header("Location: basic.php");
        exit;
    } else {
        echo "エラー: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>アカウント作成</title>
    <link rel="stylesheet" href="registar.css">
</head>
<body>
    <div class="container">
        <h1>アカウント作成</h1>
        <form method="post">
            <input type="text" name="username" placeholder="ユーザー名" required><br>
            <input type="email" name="email" placeholder="メールアドレス" required><br>
            <input type="password" name="password" placeholder="パスワード" required><br>
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>
