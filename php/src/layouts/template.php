<?php
include("/var/www/html/dbconnect.php");
?>

<?php include "/var/www/html/layouts/header.php"; ?>
<main>
    <article>
        <?php
        if ($p == "index") {
            $stmt = $pdo->query("select title,url,published_at,updated_at from works where is_published");
            $works = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($works as $work) {
                echo htmlspecialchars($work["title"], ENT_QUOTES, "UTF-8") . "<br>";
                if (is_null($work["url"])) {
                    echo "URL無し<br>";
                } else {
                    echo "<a href='" .
                        htmlspecialchars($work["url"], ENT_QUOTES, "UTF-8") .
                        "' target='_blank'>" .
                        htmlspecialchars($work["url"], ENT_QUOTES, "UTF-8") .
                        "</a><br>";

                }
                echo htmlspecialchars($work["published_at"], ENT_QUOTES, "UTF-8") . "<br>";
                echo htmlspecialchars($work["updated_at"], ENT_QUOTES, "UTF-8") . "<br>";
                echo "<br>";
            }
        } else {
        }
        ?>

    </article>
    <?php include "/var/www/html/layouts/aside.php"; ?>
</main>
<?php include "/var/www/html/layouts/footer.php"; ?>