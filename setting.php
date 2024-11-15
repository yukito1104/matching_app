<?php
// setting.php
// セッション開始
session_start();

// データベース接続
require 'config.php';

// ユーザー情報の取得
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>
<link href="setting.css" rel="stylesheet">


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>マイページ</h1>
        <nav>
           <li><a href="menu.php">さがす</a></li>
            <li><a href="like.php">いいね！</a></li>
            <li><a href="matching.php">チャット</a></li>
            
        </nav>
    </header>

    <main>
        <p>メールアドレス: <?php echo htmlspecialchars($user['email']); ?></p>
        <a href="edit_profile.php">プロフィールを編集する</a><br>
        <a href="setting2.php">各種設定</a><br>
        <a href="safe.php">安心・安全ガイド</a><br>
        <a href="logout.php">ログアウト</a>
    </main>
</body>
</html>
