<?php
require("../dbconnect.php");
session_start();

if ($_SESSION["login"]) {
    header("Location: index.php");
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $st = $db->prepare("INSERT INTO members SET name=?,email=?,password=?,enrolled=1,created=NOW()");
        $st->execute([$_POST["name"], $_POST["email"], $_POST["password"]]);
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録完了</title>

    <link rel="stylesheet" href="../css/ress.css">
    <link rel="stylesheet" href="../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Zen+Antique&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&family=Zen+Old+Mincho:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="icon" href="../images/albatross.png" type="image/png">
</head>

<body>
    <a href="../">
        <header>
            <h1>ポートフォリオ</h1>
        </header>
    </a>

    <div class="contents">
        <article>
            <h1>会員登録完了</h1>
            <p>会員登録ありがとうございます。</p>
        </article>
        <aside>
            <p><a href="../index.php">ログイン</a></p>
            <p><a href="../register_account/">会員登録</a></p>
        </aside>
    </div>
</body>

</html>