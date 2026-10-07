<?php
include getenv("PHP_ROOT_DIR") . "/dbconnect.php";

$page_name = "";

if ($page === "article") {
    $id = $_GET["id"] ?? 1;
    $sql = "SELECT * FROM articles WHERE id = ?";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $row = [];
    }

    // $page_name = ($row["title"]) ? $row["title"] . " | " : "お探しの記事は見つかりませんでした | ";
} elseif ($page === "works") {
    if (isset($_GET["word"])) {
        $word = $_GET["word"];
        $sql = "SELECT * FROM works 
                    WHERE is_published AND name LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = (int) $_GET["tag"];
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

    $page_name = "作品一覧 | ";
} else {
    if (isset($_GET["word"])) {
        $word = $_GET["word"];
        $sql = "SELECT * FROM articles 
                    WHERE is_published AND title LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = (int) $_GET["tag"];
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

    $page_name = "トップページ | ";
}

$title = $page_name . getenv("SITE_NAME");
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

    <!-- googleフォント -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=BIZ+UDPGothic&family=BIZ+UDPMincho&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&family=Zen+Antique&display=swap"
        rel="stylesheet">

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
    include getenv("PHP_LAYOUTS") . "header.php";
    ?>
    <main>
        <a href="#page_top" class="page_top_btn">
            <span class="material-symbols-outlined">
                keyboard_arrow_up
            </span>
        </a>
        <article>
            <h1 class="page_title">
                <?php
                if ($page === "article") {
                    if (isset($row["title"])) {
                        echo $row["title"];
                    }
                } elseif ($page === "works") {
                    echo "作品";
                } else {
                    echo "記事";
                }
                ?>
            </h1>
            <?php if ($page === "article"): ?>
                <div class="md">
                    <?php if (count($row) == 0): ?>
                        <p>お探しの記事は存在しないか非公開となっています。</p>
                    <?php else: ?>
                        <img src="<?= getenv("HTML_ARTICLES") ?><?= $row["id"] ?>/screenshots/thumbnail.png" alt="サムネイル"
                            class="thumbnail">
                        <div class="datetimes">
                            <div>
                                登録日時：<?= $row["published_at"] ?>
                            </div>
                            <div>
                                更新日時：<?= $row["updated_at"] ?>
                            </div>
                        </div>

                        <?php
                        $vars = [
                            "{{ARTICLES}}" => getenv("HTML_ARTICLES"),
                            "{{ID}}" => $row["id"],
                        ];

                        $md = file_get_contents(getenv('PHP_ARTICLES') . "{$id}/text.md");
                        $md = strtr($md, $vars);

                        require getenv("PHP_VENDOR") . "autoload.php";
                        $Parsedown = new Parsedown();
                        $Parsedown->setSafeMode(true);
                        $text = $Parsedown->text($md);
                        echo $text;
                        ?>
                    <?php endif; ?>
                </div>
            <?php elseif ($page === "works"): ?>
                <?php if (count($rows) == 0): ?>
                    <p>作品が見つかりませんでした。</p>
                <?php else: ?>
                    <div class="works">
                        <?php foreach ($rows as $row): ?>
                            <?php
                            $id = $row["id"];
                            $name = $row["name"];
                            $url = $row["url"];
                            ?>
                            <a href="<?= $url ?>" target="_blank" class="work">
                                <?php
                                $img_src = getenv("HTML_WORKS") . $id . "/screenshots/thumbnail.png";
                                ?>
                                <img src="<?= $img_src ?>" alt="サムネイル<?= $id ?>">
                                <h2><?php echo $name; ?></h2>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if (count($rows) == 0): ?>
                    <p>記事は見つかりませんでした。</p>
                <?php else: ?>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $id = $row["id"];
                        $title = $row["title"];
                        ?>
                        <a href="article.php?id=<?= $id ?>" class="heading">
                            <?php
                            $img_src = getenv("HTML_ARTICLES") . $id . "/screenshots/thumbnail.png";
                            ?>
                            <img src="<?= $img_src ?>" alt="サムネイル<?= $id ?>">
                            <h2><?php echo $title; ?></h2>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
        </article>
        <?php include getenv("PHP_LAYOUTS") . "aside.php"; ?>
    </main>
    <?php include getenv("PHP_LAYOUTS") . "footer.php"; ?>
    <?php include getenv("PHP_LAYOUTS") . "tail.php"; ?>