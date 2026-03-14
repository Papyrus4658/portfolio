<?php
require("../dbconnect.php");
session_start();

if ($_SESSION["login"]) {
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
    <title>作品登録</title>

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
            <?php if ($user["role"] == 0): ?>
                <h1>作品登録</h1>
                <form action="confirm.php" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($_SESSION["error_message"])) {
                        print ("<p class=\"error_message\">" . $_SESSION["error_message"] . "</p>");
                        unset($_SESSION["error_message"]);
                    }
                    ?>

                    <table>
                        <tr>
                            <th><label for="name">作品名</label></th>
                            <td><input type="text" name="name" id="name" required></td>
                        </tr>
                        <tr>
                            <th><label for="file">画像</label></th>
                            <td><input type="file" name="file" id="file"></td>
                        </tr>
                        <tr>
                            <th><label for="url">URL</label></th>
                            <td><input type="text" name="url" id="url" required></td>
                        </tr>
                        <tr>
                            <th><label for="outline">概要</label></th>
                            <td><textarea class="outline" name="outline" id="outline" required></textarea></td>
                        </tr>
                        <tr>
                            <th><label for="created">作成日</label></th>
                            <td><input type="date" name="created" id="created"></td>
                        </tr>
                    </table>

                    <button type="submit">確認</button>
                </form>

            <?php else: ?>
                <p>権限がありません。ここは管理者専用ページです。</p>
            <?php endif; ?>
        </article>

        <aside>
            <p>ようこそ <?php print ($user["name"]); ?> さん</p>
            <p><a href="../">作品一覧</a></p>

            <?php if ($user["role"] == 0): ?>
                <p>作品登録</p>
            <?php endif; ?>

            <p><a href="../logout.php">ログアウト</a></p>
            <p><a href="../quit/">退会</a></p>
        </aside>
    </div>
</body>

</html>