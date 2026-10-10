<?php if ($page === "article"): ?>
    <div class="md">
        <?php if ($row == false): ?>
            <p>お探しの記事は存在しないか非公開となっています。</p>
        <?php else: ?>
            <?php
            $id = $row["id"];
            $published_at = $row["published_at"];
            $updated_at = $row["updated_at"];
            ?>

            <img src="<?= getenv("HTML_ARTICLES") ?><?= $id ?>/screenshots/thumbnail.png" alt="サムネイル" class="thumbnail">
            <div class="datetimes">
                <p>
                    登録日時：<?= $published_at ?>
                </p>
                <p>
                    更新日時：<?= $updated_at ?>
                </p>
            </div>

            <?php
            $vars = [
                "{{IMGS}}" => getenv("HTML_ARTICLES") . $id . "\/screenshots\/"
            ];

            $md = file_get_contents("articles/{$id}/text.md");
            $md = strtr($md, $vars);

            require "vendor/autoload.php";
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
                    <h2><?= $name; ?></h2>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php elseif ($page === "about"): ?>
    <div class="md">
        <?php
        $md = file_get_contents("articles/about.md");
        // $md = strtr($md, $vars);
    
        require "vendor/autoload.php";
        $Parsedown = new Parsedown();
        $Parsedown->setSafeMode(true);
        $text = $Parsedown->text($md);
        echo $text;
        ?>
    </div>
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
                <h2><?= $title; ?></h2>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>