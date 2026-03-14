<?php
require("../dbconnect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アカウント復元</title>

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
        <?php if (isset($_SESSION["login"])): ?>
            <?php
            $st = $db->prepare("SELECT * FROM members WHERE id=?");
            $st->execute([$_SESSION["login"]]);
            $user = $st->fetch();
            ?>

            <article>
                <h1>アカウント復元</h1>

                <p>ログイン中です。</p>
                <p>アカウントを復元したい場合はログアウトして下さい。</p>
            </article>

            <aside>
                <p>ようこそ <?php print ($user["name"]); ?> さん</p>

                <?php if ($user["role"] == 0): ?>
                    <p><a href="../add_work/index.php">作品登録</a></p>
                <?php endif; ?>

                <p><a href="../logout.php">ログアウト</a></p>
                <p><a href="../quit/">退会</a></p>
            </aside>
        <?php else: ?>
            <article>
                <h1>アカウント復元</h1>

                <form action="recovered.php" method="post">
                    <?php
                    if (isset($_SESSION["error_message"])) {
                        print ("<p class=\"error_message\">" . $_SESSION["error_message"] . "</p>");
                        unset($_SESSION["error_message"]);
                    }
                    ?>

                    <table>
                        <tr>
                            <th><label for="email">ログインID</label></th>
                            <td><input type="email" name="email" id="email" required></td>
                        </tr>
                        <tr>
                            <th><label for="password">パスワード</label></th>
                            <td><input type="password" name="password" id="password" required></td>
                        </tr>
                    </table>

                    <button type="submit">復元</button>
                </form>
            </article>

            <aside>
                <p><a href="../index.php">ログイン</a></p>
                <p><a href="../register_account/">会員登録</a></p>
            </aside>
        <?php endif; ?>
    </div>
</body>

</html>