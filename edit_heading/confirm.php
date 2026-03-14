<?php
require("../dbconnect.php");
session_start();

if (isset($_SESSION["login"])) {
    $st = $db->prepare("SELECT * FROM members WHERE id=?");
    $st->execute([$_SESSION["login"]]);
    $user = $st->fetch();

    if ($user["role"] == 0) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = nt($_POST["id"]);
            $name = nt($_POST["name"]);

            $st = $db->prepare("SELECT COUNT(*) FROM my_works WHERE name=?");
            $st->execute([$name]);
            $count = $st->fetchColumn();

            if ($count > 1) {
                $error_message = "既に使用されている作品名です。";
                $_SESSION["error_message"] = $error_message;
                header("Location: index.php?id={$id}");
                exit;
            }

            $url = nt($_POST["url"]);

            $st = $db->prepare("SELECT COUNT(*) FROM my_works WHERE url=?");
            $st->execute([$url]);
            $count = $st->fetchColumn();

            if ($count > 1) {
                $error_message = "既に使用されているURLです。";
                $_SESSION["error_message"] = $error_message;
                header("Location: index.php?id={$id}");
                exit;
            }

            $outline = nl2br(nt($_POST["outline"]), false);

            if (strlen($outline) > 255) {
                $error_message = "概要は255字以内で入力して下さい。";
                $_SESSION["error_message"] = $error_message;
                header("Location: index.php?id={$id}");
                exit;
            }

            $temp_dir = "./temp/";

            if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                $file_temp_name = $_FILES["file"]["tmp_name"];
                $file_name = $_FILES["file"]["name"];
                $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                $allowed_extensions = ["gif", "jpg", "jpeg", "png"];

                if (in_array($file_extension, $allowed_extensions)) {
                    if (!is_dir($temp_dir)) {
                        mkdir($temp_dir, 0755, true);
                    }

                    $temp_file_path = $temp_dir . $file_name;
                    move_uploaded_file($file_temp_name, $temp_file_path);
                } else {
                    $error_message = "アップロード可能なのは、gif、jpg、pngのみです。";
                    header("Location: index.php");
                    exit;
                }
            } else {
                $success = "失敗";
            }
        } else {
            header("Location: index.php?id={$id}");
            exit;
        }
    } else {
        header("Location: index.php?id={$id}");
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
    <title>編集内容確認</title>

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
            <h1>編集内容確認</h1>

            <form action="edited.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php print ($id); ?>">

                <table>
                    <tr>
                        <th>作品名</th>
                        <td><?php print ($name); ?></td>
                        <input type="hidden" name="name" value="<?php print ($name); ?>">
                    </tr>
                    <tr>
                        <th>画像</th>
                        <td>
                            <?php if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK): ?>
                                <img class="preview" src="<?php print ($temp_file_path); ?>" alt="サムネイル">
                                <input type="hidden" name="file" value="<?php print ($file_name); ?>">
                            <?php else: ?>
                                <?php
                                $st = $db->prepare("SELECT image FROM my_works WHERE id=?");
                                $st->execute([$_POST["id"]]);
                                $image = $st->fetch();
                                ?>
                                <img class="preview" src="<?php print ("../" . $image); ?>" alt="サムネイル">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td><?php print ($url); ?></td>
                        <input type="hidden" name="url" value="<?php print ($url); ?>">
                    </tr>
                    <tr>
                        <th>概要</th>
                        <td><?php print ($outline); ?></td>
                        <input type="hidden" name="outline" value="<?php print ($outline); ?>">
                    </tr>
                </table>

                <button type="submit">更新</button>
                <p><a href="index.php?id=<?php print ($id); ?>">キャンセル</a></p>
            </form>
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