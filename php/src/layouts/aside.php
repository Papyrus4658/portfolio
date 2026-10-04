<?php
if ($page === "works") {
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
    <div class="search">
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
                    <a href="<?= $action ?>?tag=<?= $row["id"] ?>">
                        <span class="material-symbols-outlined">shoppingmode</span>
                        <?= $row["name"] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</aside>