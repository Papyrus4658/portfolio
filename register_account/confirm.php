<?php
require("../dbconnect.php");
session_start();
if ($_SESSION["login"]) {
    header("Location: index.php");
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = nt($_POST["name"]);

        $st = $db->prepare("SELECT COUNT(*) FROM members WHERE name=?");
        $st->execute([$name]);
        $count = $st->fetchColumn();

        if ($count > 0) {
            $error_message = "既に使用されている名前です。";
            $_SESSION["error_message"] = $error_message;
            header("Location: index.php");
            exit;
        }

        $email = nt($_POST["email"]);

        $st = $db->prepare("SELECT COUNT(*) FROM members WHERE email=?");
        $st->execute([$email]);
        $count = $st->fetchColumn();

        if ($count > 0) {
            $error_message = "既に使用されているIDです。";
            $_SESSION["error_message"] = $error_message;
            header("Location: index.php");
            exit;
        }

        if (mb_strlen(nt($_POST["password"])) < 8) {
            $error_message = "パスワードは8字以上でお願いします。";
            $_SESSION["error_message"] = $error_message;
            header("Location: index.php");
            exit;
        }

        $hidden_password = str_repeat("*", mb_strlen(nt($_POST["password"])));
        $password = password_hash(nt($_POST["password"]), PASSWORD_DEFAULT);
    } else {
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録情報確認</title>

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
            <h1>登録情報確認</h1>

            <form action="registered.php" method="post">
                <p>以下の情報で登録します。宜しいですか。</p>
                <table>
                    <tr>
                        <th><label for="name">名前</label></th>
                        <td><?php print ($name); ?></td>
                        <input type="hidden" name="name" id="name" value="<?php print ($name); ?>">
                    </tr>
                    <tr>
                        <th><label for="email">メールアドレス</label></th>
                        <td><?php print ($email); ?></td>
                        <input type="hidden" name="email" id="email" value="<?php print ($email); ?>">
                    </tr>
                    <tr>
                        <th><label for="password">パスワード</label></th>
                        <td><?php print ($hidden_password); ?></td>
                        <input type="hidden" name="password" id="password" value="<?php print ($password); ?>">
                    </tr>
                </table>

                <button type="submit">登録</button>
            </form>

            <a href="index.php">キャンセル</a>
        </article>

        <aside>
            <p><a href="../">ログイン</a></p>
            <p><a href="../recover_account/">アカウント復元</a></p>
        </aside>
    </div>
</body>

</html>