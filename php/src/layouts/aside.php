<?php
if ($page === "works") {
    $form_label = "作品を検索";
    $action = "works.php";
    $sql = "SELECT t.id, name
                FROM tags as t
                WHERE
                    t.id = (
                        SELECT DISTINCT
                            tag_id
                        FROM work_tags as wt
                            INNER JOIN works as w ON wt.work_id = w.id
                        WHERE
                            w.is_published
                            AND t.id = tag_id
                    )
                ORDER BY t.id";
} else {
    $form_label = "記事を検索";
    $action = "index.php";
    $sql = "SELECT t.id, name
                FROM tags as t
                WHERE
                    t.id = (
                        SELECT DISTINCT
                            tag_id
                        FROM article_tags as at
                            INNER JOIN articles as a ON at.article_id = a.id
                        WHERE
                            a.is_published
                            AND t.id = tag_id
                    )
                ORDER BY t.id";
}

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<aside>
    <h1><?= $form_label ?></h1>

    <form action="<?= $action ?>" method="get" class="word_search">
        <input type="text" name="word" id="word">
        <button type="submit">
            <span class="material-symbols-outlined">search</span>
        </button>
    </form>

    <?php if (count($rows) == 0): ?>
        <p>現在有効なタグはありません。</p>
    <?php else: ?>
        <div class="tag_search">
            <?php foreach ($rows as $row): ?>
                <!-- <form action="<?= $action ?>" method="get">
                    <input type="hidden" name="tag" id="tag" value="<?= $row["id"] ?>">
                    <button type="submit">
                        <span class="material-symbols-outlined">shoppingmode</span>
                        <?= $row["name"] ?>
                    </button>
                </form> -->
                <a href="<?= $action ?>?tag=<?= $row["id"] ?>">
                    <span class="material-symbols-outlined">shoppingmode</span>
                    <?= $row["name"] ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</aside>