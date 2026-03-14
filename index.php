<?php
require("dbconnect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポートフォリオ</title>

    <link rel="stylesheet" href="css/ress.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Zen+Antique&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&family=Zen+Old+Mincho:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">

    <link rel="icon" href="images/albatross.png" type="image/png">
</head>

<body>
    <header>
        <h1>ポートフォリオ</h1>
    </header>

    <div class="contents">
        <?php if (isset($_SESSION["login"])): ?>
            <?php
            $st = $db->prepare("SELECT * FROM members WHERE id=?");
            $st->execute([$_SESSION["login"]]);
            $user = $st->fetch();
            $st = $db->query("SELECT * FROM my_works WHERE visible=1 ORDER BY id DESC");
            ?>

            <article>
                <h1>作品一覧</h1>

                <?php while ($my_work = $st->fetch()): ?>
                    <div class="my_work">
                        <a href="details/index.php?id=<?php print ($my_work["id"]); ?>">
                            <figure>
                                <img src="<?php print ($my_work["image"]); ?>" alt="サムネイル">
                                <figcaption>
                                    <h2><?php print ($my_work["name"]); ?></h2>
                                    <!-- <hr> -->
                                    <p class="outline"><?php print ($my_work["outline"]); ?></p>
                                </figcaption>
                            </figure>
                            <!-- <hr> -->
                        </a>

                        <div class="appendix">
                            <div class="edit">
                                <?php if ($user["role"] == 0): ?>
                                    <a href="edit_heading/index.php?id=<?php print ($my_work["id"]); ?>">
                                        [編集]
                                    </a>
                                    <a href="hide_work/index.php?id=<?php print ($my_work["id"]); ?>">
                                        [削除]
                                    </a>
                                <?php endif; ?>
                            </div>
                            <p class="url">
                                <a href="<?php print ($my_work["url"]); ?>"><?php print ($my_work["url"]); ?></a>
                            </p>
                            <p class="created">
                                <time datetime="<?php print ($my_work["created"]); ?>">
                                    作成日 :
                                    <?php print (date("Y/m/d", strtotime($my_work["created"]))); ?>
                                </time>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </article>

            <aside>
                <p>ようこそ <?php print ($user["name"]); ?> さん</p>
                <p>作品一覧</p>

                <?php if ($user["role"] == 0): ?>
                    <p><a href="add_work/">作品登録</a></p>
                <?php endif; ?>

                <p><a href="logout.php">ログアウト</a></p>
                <p><a href="quit/">退会</a></p>
            </aside>
        <?php else: ?>
            <article>
                <h1>ログイン</h1>
                <form action="login.php" method="post">
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

                    <button type="submit">ログイン</button>
                </form>
            </article>

            <aside>
                <p><a href="register_account/">会員登録</a></p>
                <p><a href="recover_account/">アカウント復元</a></p>
            </aside>
        <?php endif; ?>
    </div>
</body>

</html>