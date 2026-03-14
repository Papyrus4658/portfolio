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
    <title>作品削除</title>

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
            <h1>作品削除</h1>
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
                            <form action="hid.php" method="post">
                                <p>以下の作品を削除します。宜しいですか。</p>

                                <table>
                                    <tr>
                                        <th>作品名</th>
                                        <td><?php print ($work["name"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>画像</th>
                                        <td>
                                            <img class="preview" src="<?php print ("../" . $work["image"]); ?>" alt="サムネイル">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>URL</th>
                                        <td><?php print ($work["url"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>概要</th>
                                        <td class="outline"><?php print ($work["outline"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>作成日</th>
                                        <td><?php print ($work["created"]); ?></td>
                                    </tr>
                                </table>

                                <input type="hidden" name="id" value="<?php print ($id); ?>">

                                <button type="submit">削除</button>
                            </form>
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
        </article>

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