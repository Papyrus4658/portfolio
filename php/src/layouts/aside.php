<?php
if ($page === "programs") {
    $form_label = "作品を検索";
    $action = "programs.php";
    $sql = "SELECT t.id,t.name FROM tags as t 
                WHERE t.id = (
                    SELECT DISTINCT pt.tag_id 
                    FROM program_tags as pt 
                    WHERE t.id = pt.tag_id
                ) ORDER BY t.id";
} else {
    $form_label = "記事を検索";
    $action = "index.php";
    $sql = "SELECT t.id,t.name FROM tags as t 
                WHERE t.id = (
                    SELECT DISTINCT pt.tag_id 
                    FROM process_tags as pt 
                    WHERE t.id = pt.tag_id
                ) ORDER BY t.id";
}

// タグを取得
// $sql = "SELECT * FROM tags ORDER BY id";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<aside>
    <h1>検索</h1>

    <form action="<?= $action ?>" method="get" class="word_search">
        <label for="word"><?= $form_label ?></label>
        <input type="text" name="word" id="word">
        <button type="submit">検索</button>
    </form>

    <?php foreach ($rows as $row): ?>
        <form action="<?= $action ?>" method="get" class="tag_search">
            <input type="hidden" name="tag" id="tag" value="<?= $row["id"] ?>">
            <button type="submit">
                <?= $row["name"] ?>
            </button>
        </form>
    <?php endforeach; ?>
</aside>