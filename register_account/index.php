<?php
require("../dbconnect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>

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
                <h1>会員登録</h1>

                <p>ログイン中です。</p>
                <p>新しく会員登録したい場合はログアウトして下さい。</p>
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
                <h1>会員登録</h1>

                <form action="confirm.php" method="post">
                    <?php
                    if (isset($_SESSION["error_message"])) {
                        print ("<p class=\"error_message\">" . $_SESSION["error_message"] . "</p>");
                        unset($_SESSION["error_message"]);
                    }
                    ?>

                    <table>
                        <tr>
                            <th><label for="name">名前</label></th>
                            <td><input type="text" name="name" id="name" required"></td>
                        </tr>
                        <tr>
                            <th><label for="email">ログインID</label></th>
                            <td><input type="email" name="email" id="email" required placeholder="メールアドレスの形式で入力して下さい。"></td>
                        </tr>
                        <tr>
                            <th><label for="password">パスワード</label></th>
                            <td><input type="password" name="password" id="password" required placeholder="8字以上"></td>
                        </tr>
                    </table>

                    <button type="submit">確認</button>
                </form>

                <aside>
                    <p><a href="../">ログイン</a></p>
                    <p><a href="../recover_account/">アカウント復元</a></p>
                </aside>
            </article>
        <?php endif; ?>
    </div>
</body>

</html>