<?php
require("../dbconnect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会</title>

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
    <?php if (isset($_SESSION["login"])): ?>
        <?php
        $st = $db->prepare("SELECT * FROM members WHERE id=?");
        $st->execute([$_SESSION["login"]]);
        $user = $st->fetch();
        ?>

        <a href="../">
            <header>
                <h1>ポートフォリオ</h1>
            </header>
        </a>

        <div class="contents">
            <article>
                <h1>退会手続き</h1>

                <form action="quit.php" method="post">
                    <p>退会します。本当に宜しいですか。</p>

                    <table>
                        <tr>
                            <th><label for="name">名前</label></th>
                            <td><?php print ($user["name"]); ?></td>
                            <input type="hidden" name="name" id="name" value="<?php print ($user["name"]); ?>">
                        </tr>
                        <tr>
                            <th><label for="email">ログインID</label></th>
                            <td><?php print ($user["email"]); ?></td>
                            <input type="hidden" name="email" id="email" value="<?php print ($user["email"]); ?>">
                        </tr>
                    </table>

                    <button type="submit">退会</button>
                </form>

                <a href="../">キャンセル</a>
            </article>

            <aside>
                <p>ようこそ <?php print ($user["name"]); ?> さん</p>
                <p><a href="../">作品一覧</a></p>

                <?php if ($user["role"] == 0): ?>
                    <p><a href="../add_work/">作品登録</a></p>
                <?php endif; ?>

                <p><a href="../logout.php">ログアウト</a></p>
                <p>退会</p>
            </aside>

        </div>
    <?php else: ?>
        <?php header("Location: ../index.php"); ?>
    <?php endif; ?>
</body>

</html>