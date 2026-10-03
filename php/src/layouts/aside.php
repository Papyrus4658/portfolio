<?php
if ($page === "works") {
    $form_label = "作品を検索";
    $action = "works.php";
    $sql = "SELECT t.id,t.name FROM tags as t 
                WHERE t.id = (
                    SELECT DISTINCT pt.tag_id 
                    FROM work_tags as pt 
                    WHERE t.id = pt.tag_id
                ) ORDER BY t.id";
} else {
    $form_label = "記事を検索";
    $action = "index.php";
    $sql = "SELECT t.id,t.name FROM tags as t 
                WHERE t.id = (
                    SELECT DISTINCT pt.tag_id 
                    FROM article_tags as pt 
                    WHERE t.id = pt.tag_id
                ) ORDER BY t.id";
}

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<aside>
    <h1>検索</h1>

    <form action="<?= $action ?>" method="get" class="word_search">
        <h2>
            <label for="word">
                <?= $form_label ?>
            </label>
        </h2>
        <input type="text" name="word" id="word">
        <button type="submit">検索</button>
    </form>

    <h2>タグ検索</h2>
    <?php if (count($rows) == 0): ?>
        <p>現在有効なタグはありません。</p>
    <?php else: ?>
        <?php foreach ($rows as $row): ?>
            <div class="tag_search">
                <form action="<?= $action ?>" method="get">
                    <input type="hidden" name="tag" id="tag" value="<?= $row["id"] ?>">
                    <button type="submit">
                        <?= $row["name"] ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</aside>