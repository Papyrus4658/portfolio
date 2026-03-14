<?php
require("../../dbconnect.php");
session_start();

if (isset($_SESSION["login"])) {
    $st = $db->prepare("SELECT * FROM members WHERE id=?");
    $st->execute([$_SESSION["login"]]);
    $user = $st->fetch();
} else {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>情報追加</title>

    <link rel="stylesheet" href="../../css/ress.css">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Zen+Antique&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&family=Zen+Old+Mincho:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="icon" href="../images/albatross.png" type="image/png">
</head>

<body>
    <a href="../../">
        <header>
            <h1>ポートフォリオ</h1>
        </header>
    </a>

    <div class="contents">
        <?php if (isset($_SESSION["login"])): ?>
            <?php
            $st = $db->prepare("SELECT * FROM members WHERE id=?");
            $st->execute([$_SESSION["login"]]);
            $user = $st->fetch();
            ?>

            <article>
                <h1>情報追加</h1>
            </article>

            <aside>
                <p>ようこそ <?php print ($user["name"]); ?> さん</p>
                <p><a href="../../">作品一覧</a></p>

                <?php if ($user["role"] == 0): ?>
                    <p><a href="../../add_work/">作品登録</a></p>
                <?php endif; ?>

                <p><a href="../../logout.php">ログアウト</a></p>
                <p><a href="../../quit/">退会</a></p>
            </aside>
        <?php else: ?>
        <?php endif; ?>
    </div>
</body>

</html>