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
    <title>見出し編集</title>

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
        <?php if ($user["role"] == 0): ?>
            <?php if (isset($_REQUEST["id"])): ?>
                <?php
                $id = $_REQUEST["id"];
                ?>

                <?php if (is_numeric($id)): ?>
                    <?php
                    $st = $db->prepare("SELECT * FROM my_works WHERE id=? AND visible=1");
                    $st->execute([$id]);
                    $work = $st->fetch();
                    ?>

                    <?php if ($work): ?>
                        <?php
                        $outline = str_replace(["<br>", "<br />"], "\n", $work["outline"]);
                        ?>

                        <article>
                            <h1>見出し編集</h1>

                            <form action="confirm.php" method="post" enctype="multipart/form-data">
                                <?php
                                if (isset($_SESSION["error_message"])) {
                                    print ("<p class=\"error_message\">" . $_SESSION["error_message"] . "</p>");
                                    unset($_SESSION["error_message"]);
                                }
                                ?>
                                <input type="hidden" name="id" id="id" value="<?php print ($work["id"]); ?>">

                                <table>
                                    <tr>
                                        <th><label for="name">作品名</label></th>
                                        <td><input type="name" name="name" id="name" value="<?php print ($work["name"]); ?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><label for="file">画像</label></th>
                                        <td><input type="file" name="file" id="file"></td>
                                    </tr>
                                    <tr>
                                        <th><label for="url">URL</label></th>
                                        <td><input type="url" name="url" id="url" value="<?php print ($work["url"]); ?>" required></td>
                                    </tr>
                                    <tr>
                                        <th><label for="outline">概要</label></th>
                                        <td><textarea name="outline" id="outline" required><?php print ($outline); ?></textarea></td>
                                    </tr>
                                </table>

                                <button type="submit">確認</button>
                            </form>
                        </article>
                    <?php else: ?>
                        <p class="error_message">無効な値が入力されました。</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="error_message">無効な値が入力されました。</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="error_message">ここに直接来ないで下さい。</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="error_message">権限がありません。ここは管理者専用ページです。</p>
        <?php endif; ?>

        <aside>
            <p>ようこそ <?php print ($user["name"]); ?> さん</p>
            <p><a href="../index.php">作品一覧</a></p>

            <?php if ($user["role"] == 0): ?>
                <p><a href="../add_work/">作品登録</a></p>
            <?php endif; ?>

            <p><a href="../logout.php">ログアウト</a></p>
            <p><a href="../quit/">退会</a></p>
        </aside>
    </div>
</body>

</html>