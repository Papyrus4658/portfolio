<?php
require("../dbconnect.php");
session_start();

if ($_SESSION["login"]) {
    $st = $db->prepare("SELECT * FROM members WHERE id=?");
    $st->execute([$_SESSION["login"]]);
    $user = $st->fetch();

    if ($user["role"] == 0) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $file_name = $_POST["file"];
            $temp_dir = "./temp/";
            $dir = "images/heading/";

            if (!is_dir(($dir))) {
                mkdir($dir, 0755, true);
            }

            $temp_file_path = $temp_dir . $file_name;
            $file_path = $dir . $file_name;

            if (rename($temp_file_path, "../" . $file_path)) {
                deleteFilesInDirectory($temp_dir);
            } else {
                $error_message = "ファイルアップロード失敗";
                $_SESSION["error_message"] = $error_message;
                header("Location: index.php");
                exit;
            }

            $st = $db->prepare("INSERT INTO my_works SET name=?,image=?,url=?,outline=?,visible=1,created=?");
            $st->execute([$_POST["name"], $file_path, $_POST["url"], $_POST["outline"], $_POST["created"]]);
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
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
    <title>登録完了</title>

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
            <h1>作品追加完了</h1>
            <p>作品の追加が完了しました。</p>
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