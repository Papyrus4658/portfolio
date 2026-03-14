<?php
require("../dbconnect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会完了</title>

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
    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <?php
        $st = $db->prepare("UPDATE members SET enrolled=0 WHERE name=?");
        $st->execute([$_POST["name"]]);
        unset($_SESSION["login"]);
        ?>

        <a href="../">
            <header>
                <h1>ポートフォリオ</h1>
            </header>
        </a>

        <div class="contents">
            <article>
                <h1>退会完了</h1>
                <p>退会手続きが完了しました。</p>
            </article>

            <aside>
                <p><a href="../">ログイン</a></p>
                <p><a href="../register_account/">会員登録</a></p>
            </aside>
        </div>
    <?php else: ?>
        <?php
        header("Location: index.php");
        exit;
        ?>
    <?php endif; ?>
</body>

</html>