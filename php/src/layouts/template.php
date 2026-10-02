<?php
include getenv("PHP_ROOT_DIR") . "/dbconnect.php";

$page_name = "";

if ($page === "process") {
    $id = $_GET["id"] ?? 1;
    $sql = "SELECT * FROM processes WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $page_name = $row["title"] . " | ";
} elseif ($page === "programs") {
    if (isset($_GET["word"])) {
        $word = $_GET["word"];
        $sql = "SELECT * FROM programs 
                    WHERE is_published AND name LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = $_GET["tag"];
        $sql = "SELECT * FROM programs as p 
                    INNER JOIN program_tags as pt 
                    ON p.id = pt.program_id 
                    WHERE is_published AND pt.tag_id = ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($tag);
    } else {
        $sql = "SELECT * FROM programs WHERE is_published ORDER BY id DESC";
        $stmt = $pdo->query($sql);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $page_name = "作品一覧 | ";
} else {
    if (isset($_GET["word"])) {
        $word = $_GET["word"];
        $sql = "SELECT * FROM processes 
                    WHERE is_published AND title LIKE ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$word%"]);
    } elseif (isset($_GET["tag"])) {
        $tag = (int) $_GET["tag"];
        $sql = "SELECT * FROM processes as p 
                    INNER JOIN process_tags as pt 
                    ON p.id = pt.process_id 
                    WHERE is_published AND pt.tag_id = ? 
                    ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tag]);
    } else {
        $sql = "SELECT * FROM processes WHERE is_published ORDER BY id DESC";
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
</head>

<body>
    <?php
    include getenv("PHP_LAYOUTS") . "header.php";
    ?>
    <main>
        <article>
            <?php if ($page === "process"): ?>
                <?php if (count($row) == 0): ?>
                    <p>該当記事が存在しません。</p>
                <?php else: ?>
                    <div class='datetime'>
                        <small>登録日時：
                            <?= $row["published_at"] ?>
                        </small>
                        <small>更新日時：
                            <?= $row["updated_at"] ?>
                        </small>
                    </div>

                    <?php
                    $vars = [
                        "{{PROCESSES}}" => getenv("HTML_PROCESSES"),
                        "{{ID}}" => $row["id"],
                    ];

                    $md = file_get_contents(getenv('PHP_PROCESSES') . "{$id}/text.md");
                    $md = strtr($md, $vars);

                    require getenv("PHP_VENDOR") . "autoload.php";
                    $Parsedown = new Parsedown();
                    $Parsedown->setSafeMode(true);
                    $text = $Parsedown->text($md);
                    echo $text;
                    ?>
                <?php endif; ?>
            <?php elseif ($page === "programs"): ?>
                <?php if (count($rows) == 0): ?>
                    <p>現在登録されている作品はありません。</p>
                <?php else: ?>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $id = $row["id"];
                        $name = $row["name"];
                        $url = $row["url"];
                        ?>
                        <a href="<?= $url ?>" target="_blank" class="program">
                            <?php
                            $img_src = getenv("HTML_PROGRAMS") . $id . "/screenshots/thumbnail.png";
                            ?>
                            <img src="<?= $img_src ?>" alt="サムネイル<?= $id ?>">
                            <h2><?php echo $name; ?></h2>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php if (count($rows) == 0): ?>
                    <p>現在公開されている記事はありません。</p>
                <?php else: ?>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $id = $row["id"];
                        $title = $row["title"];
                        ?>
                        <a href="process.php?id=<?= $id ?>" class="process">
                            <?php
                            $img_src = getenv("HTML_PROCESSES") . $id . "/screenshots/thumbnail.png";
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