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
    <button class="hamburger" type="button" type="button" aria-label="open" aria-expanded="false"
        aria-controls="search">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
    </button>

    <!-- メニュー外をタップして閉じるための暗幕 -->
    <div class="overlay"></div>

    <div class="search" id="search">
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
                        <?= $row["name"] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</aside>

<script>
    const hamburger = document.querySelector(".hamburger");
    const search = document.querySelector(".search");
    const overlay = document.querySelector(".overlay");

    function setOpen(isOpen) {
        hamburger.classList.toggle("is-active", isOpen);
        search.classList.toggle("is-open", isOpen);
        overlay.classList.toggle("is-open", isOpen);
        hamburger.setAttribute("aria-expanded", isOpen);
        hamburger.setAttribute("aria-label", isOpen ? "close" : "open");
    }

    hamburger.addEventListener("click", () => setOpen(!search.classList.contains("is-open")));
    overlay.addEventListener("click", () => setOpen(false));
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") setOpen(false);
    });
</script>