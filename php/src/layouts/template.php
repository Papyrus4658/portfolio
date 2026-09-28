<?php
include("/var/www/html/dbconnect.php");
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
            <?php if ($p == "index"): ?>
                <h1>PROCESS</h1>

                <?php
                $stmt = $pdo->query(
                    "select * from works where is_published order by id"
                );
                $works = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php foreach ($works as $work): ?>
                    <?php
                    $id = $work["id"];
                    $href = "details.php?id=$id";
                    $img_src = "/articles/" . $id . "/screenshots/thumbnail.png";
                    ?>

                    <a href="<?= htmlspecialchars($href, ENT_QUOTES, "UTF-8") ?>" class=" work">
                        <img src="<?= htmlspecialchars($img_src, ENT_QUOTES, "UTF-8") ?>" alt="サムネイル$id">
                        <h2>
                            <?php
                            echo htmlspecialchars($work["title"], ENT_QUOTES, "UTF-8");
                            ?>
                        </h2>
                        <p>
                            <?php
                            $f = fopen("/var/www/html/articles/$id/text.md", "r");
                            $preview = fread($f, 150);
                            fclose($f);
                            echo $preview . "...";
                            ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <?php
                require "vendor/autoload.php";
                $id = $_GET["id"];
                $fname = "articles/$id/text.md";

                $Parsedown = new Parsedown();

                $md = file_get_contents($fname);
                echo $Parsedown->text($md);
                ?>
            <?php endif; ?>
        </article>
        <?php include "/var/www/html/layouts/aside.php"; ?>
    </main>
    <?php include "/var/www/html/layouts/footer.php"; ?>