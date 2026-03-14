<?php
require("../dbconnect.php");
session_start();

if (isset($_SESSION["login"])) {
    $st = $db->prepare("SELECT * FROM members WHERE id=?");
    $st->execute([$_SESSION["login"]]);
    $user = $st->fetch();
} else {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作品詳細</title>

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
            <?php if (isset($_REQUEST["id"])): ?>
                <?php
                $id = $_REQUEST["id"];
                ?>
                <?php if (is_numeric($id)): ?>
                    <?php
                    $st = $db->prepare("SELECT * FROM details WHERE work_id=? ORDER BY num");
                    $st->execute([$id]);
                    ?>

                    <?php if ($st->rowCount() > 0): ?>
                        <h1>詳細</h1>

                        <?php while ($detail = $st->fetch()): ?>
                            <figure class="detail">
                                <img src="<?php print ($detail["image"]); ?>" alt="サムネイル">
                                <figcaption>
                                    <h2><?php print ($detail["title"]); ?></h2>
                                    <!-- <hr> -->
                                    <p class="explaination"><?php print ($detail["explaination"]); ?></p>
                                </figcaption>
                            </figure>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>作成中</p>
                    <?php endif; ?>

                    <!-- <?php if ($user["role"] == 0): ?> -->
                        <!-- <p><a href="add_explaination/index.php?">情報追加</a></p> -->
                        <!-- <?php endif; ?> -->
                <?php else: ?>
                    <p class="error_message">無効な値が入力されました。</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="error_message">ここに直接来ないで下さい。</p>
            <?php endif; ?>
        </article>

        <aside>
            <p>ようこそ <?php print ($user["name"]); ?> さん</p>
            <p><a href="../">作品一覧</a></p>

            <?php if ($user["role"] == 0): ?>
                <p><a href="../add_work/">作品登録</a></p>
            <?php endif; ?>

            <p><a href="../logout.php">ログアウト</a></p>
            <p><a href="../quit/">退会</a></p>
        </aside>
    </div>
</body>

</html>