<?php
include "/var/www/html/dbconnect.php";
?>

<?php include "/var/www/html/layouts/header.php"; ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress of Wisdom</title>
</head>

<body>
    <main>
        <article>
            <?php if ($page === "process"): ?>
                <?php
                $id = $_GET["id"] ?? 1;
                $sql = "SELECT * FROM processes WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<h1>{$row['title']}</h1>";
                echo "
                <div class='datetime'>
                    <small>登録日時：{$row['published_at']}</small>
                    <small>更新日時：{$row['updated_at']}</small>
                </div>
                ";

                require "/var/www/html/vendor/autoload.php";
                $Parsedown = new Parsedown();
                $Parsedown->setSafeMode(true);
                $md = file_get_contents("/var/www/html/processes/{$id}/text.md");
                echo $Parsedown->text($md);
                ?>
            <?php elseif ($page === "programs"): ?>
                <h1>Programs</h1>
                <?php
                if (isset($_GET["word"])) {
                    $word = $_GET["word"];
                    $sql = "SELECT * FROM programs 
                    WHERE is_published AND title LIKE ? 
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
                    // $stmt = $pdo->prepare($sql);
                    // $stmt->execute();
                }

                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($rows as $row): ?>
                    <?php
                    $id = $row["id"];
                    $name = $row["name"];
                    $url = $row["url"];
                    ?>
                    <a href="<?= $url ?>" class="program">
                        <img src="/programs/<?= $id ?>/screenshots/thumbnail.png" alt="サムネイル<?= $id ?>">
                        <h2><?php echo $name; ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <h1>Processes</h1>
                <?php
                if (isset($_GET["word"])) {
                    $word = $_GET["word"];
                    $sql = "SELECT * FROM processes 
                    WHERE is_published AND title LIKE ? 
                    ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(["%$word%"]);
                } elseif (isset($_GET["tag"])) {
                    $tag = $_GET["tag"];
                    $sql = "SELECT * FROM processes as p 
                    INNER JOIN process_tags as pt 
                    ON p.id = pt.process_id 
                    WHERE is_published AND pt.tag_id = ? 
                    ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($tag);
                } else {
                    $sql = "SELECT * FROM processes WHERE is_published ORDER BY id DESC";
                    $stmt = $pdo->query($sql);
                }
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <?php foreach ($rows as $row): ?>
                    <?php
                    $id = $row["id"];
                    $title = $row["title"];
                    ?>
                    <a href="process.php?id=<?= $id ?>" class="process">
                        <img src="/processes/<?= $id ?>/screenshots/thumbnail.png" alt="サムネイル<?= $id ?>">
                        <h2><?php echo $title; ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </article>
        <?php include "/var/www/html/layouts/aside.php"; ?>
    </main>
    <?php include "/var/www/html/layouts/footer.php"; ?>