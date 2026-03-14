<?php
require("../dbconnect.php");
session_start();

if ($_SESSION["login"]) {
    $st = $db->prepare("SELECT * FROM members WHERE id=?");
    $st->execute([$_SESSION["login"]]);
    $user = $st->fetch();

    if ($user["role"] == 0) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = nt($_POST["id"]);
            $name = nt($_POST["name"]);
            $url = nt($_POST["url"]);
            $outline = $_POST["outline"];

            if (isset($_POST["file"])) {
                $file_name = $_POST["file"];
                $temp_dir = "./temp/";
                $dir = "images/heading/";

                if (!is_dir(($dir))) {
                    mkdir($dir, 0755, true);
                }

                $temp_file_path = $temp_dir . $file_name;
                $file_path = $dir . $file_name;

                if (file_exists("../" . $file_path)) {
                    unlink($file_path); // 既存ファイルを削除
                }

                if (rename($temp_file_path, "../" . $file_path)) {
                    deleteFilesInDirectory($temp_dir);
                } else {
                    $error_message = "ファイルアップロード失敗";
                    $_SESSION["error_message"] = $error_message;
                    header("Location: index.php");
                    exit;
                }

                $st = $db->prepare("UPDATE my_works SET name=?,image=?,url=?,outline=? WHERE id=?");
                $st->execute([$name, $file_path, $url, $outline, $id]);
            } else {
                $st = $db->prepare("UPDATE my_works SET name=?,url=?,outline=? WHERE id=?");
                $st->execute([$name, $url, $outline, $id]);
            }
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集完了</title>

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
            <h1>編集完了</h1>
            <p>編集が完了しました。</p>
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