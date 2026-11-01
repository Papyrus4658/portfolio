<?php if ($page === "article"): ?>
    <div class="md">
        <?php if ($row == false): ?>
            <p>お探しの記事は存在しないか非公開となっています。</p>
        <?php else: ?>
            <?php
            $id = $row["id"];
            $filename = "articles/{$id}/text.md";
            $updatedtime = filemtime($filename);
            $updatedtime_str = date("Y-m-d H:i:s", $updatedtime);
            ?>

            <img src="<?= getenv("HTML_ARTICLES") ?><?= $id ?>/imgs/top.png" alt="サムネイル" class="thumbnail">
            <div class="datetimes">
                <p class="datetime">更新日時：<?= $updatedtime_str ?></p>
            </div>

            <?php
            $vars = [
                "{{IMGS}}" => getenv("HTML_ARTICLES") . $id . "\/imgs\/"
            ];

            $md = file_get_contents($filename);
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
                    $img_src = getenv("HTML_WORKS") . $id . "/imgs/top.png";
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
<?php elseif ($page === "index"): ?>
    <?php if (count($rows) == 0): ?>
        <p>記事は見つかりませんでした。</p>
    <?php else: ?>
        <?php foreach ($rows as $row): ?>
            <?php
            $id = $row["id"];
            $title = $row["title"];
            ?>
            <div class="heading">
                <a href="article.php?id=<?= $id ?>">
                    <h2><?= $title; ?></h2>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<? elseif ($page === "bbs"): ?>
    <?php if (count($rows) > 0): ?>
        <div class="bbs">
            <?php foreach ($rows as $row): ?>
                <?php
                $handle = $row["handle"];
                $post = $row["post"];
                $published_at = $row["published_at"];
                ?>
                <div class="post">
                    <p>
                        <span class="handle"><?= $handle; ?></span>
                        <span><?= $published_at; ?></span>
                    </p>
                    <p class="text"><?= $post; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="./post.php" method="post" class="post_form">
        <p><label for="handle">名前</label></p>
        <p><input type="text" name="handle" id="handle" required></p>
        <p><label for="post">本文</label></p>
        <p><textarea name="post" id="post" rows="10" cols="30" required></textarea></p>

        <button type="submit">投稿</button>
    </form>

    <?php if (isset($_SESSION["register"])): ?>
        <?php if ($_SESSION["register"] === "success"): ?>
            <p class="success">投稿しました。</p>
        <?php else: ?>
            <p class="fail">投稿に失敗しました。</p>
        <?php endif; ?>
    <? endif; ?>
<?php endif; ?>