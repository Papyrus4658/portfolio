<?php
include "/var/www/html/dbconnect.php";

$title_prefix = "";

if ($page === "article") {
    if (isset($_GET["id"])) {
        $id = htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8");
        $id = (int) $id;
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $title_prefix = (isset($row["title"])) ? $row["title"] : "記事が存在しません";
    }
} elseif ($page === "works") {
    if (isset($_GET["word"])) {
        $word = htmlspecialchars($_GET["word"], ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM works 
                    WHERE is_published AND name LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = (int) htmlspecialchars($_GET["tag"], ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM works as w
                    INNER JOIN work_tags as wt
                    ON id = work_id 
                    WHERE is_published AND tag_id = ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tag]);
    } else {
        $sql = "SELECT * FROM works WHERE is_published ORDER BY id DESC";
        $stmt = $pdo->query($sql);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $title_prefix = "作品";
} elseif ($page === "about") {
    $title_prefix = "このサイトについて";
} elseif ($page === "index") {
    if (isset($_GET["word"])) {
        $word = htmlspecialchars($_GET["word"], ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM articles 
                    WHERE is_published AND title LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = (int) htmlspecialchars($_GET["tag"], ENT_QUOTES, "UTF-8");
        $sql = "SELECT * FROM articles as a
                    INNER JOIN article_tags as at
                    ON id = article_id 
                    WHERE is_published AND tag_id = ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tag]);
    } else {
        $sql = "SELECT * FROM articles WHERE is_published ORDER BY id DESC";
        $stmt = $pdo->query($sql);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $title_prefix = "記事";
}

$title = $title_prefix . " | " . getenv("SITE_NAME");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <!-- リセットcss -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <!-- <link rel="stylesheet" href="node_modules/modern-normalize/modern-normalize.css"> -->

    <!-- google icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- シンタックスハイライト -->
    <link rel="stylesheet" media="(prefers-color-scheme: light)"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.12.0/styles/base16/solarized-light.min.css">
    <link rel="stylesheet" media="(prefers-color-scheme: dark)"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.12.0/styles/base16/solarized-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.12.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <!-- 自分のcss -->
    <link rel="stylesheet" href="<?= getenv("HTML_CSS") ?>style.css">
</head>

<body id="page_top">
    <?php
    include __DIR__ . "/header.php";
    ?>
    <main>
        <a href="#page_top" class="page_top_btn">
            <span class="material-symbols-outlined">
                keyboard_arrow_up
            </span>
        </a>
        <article>
            <h1 class="page_title">
                <?= $title_prefix; ?>
            </h1>
            <?php include __DIR__ . "/content.php"; ?>
        </article>
        <?php include __DIR__ . "/aside.php"; ?>
    </main>
    <?php include __DIR__ . "/footer.php"; ?>
    <?php include __DIR__ . "/tail.php"; ?>