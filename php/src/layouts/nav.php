<nav>
    <ul>
        <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
            <li>
                <span class="material-symbols-outlined">article</span>
                <?= getenv("ARTICLES") ?>
            </li>
        </a>
        <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
            <li>
                <span class="material-symbols-outlined">deployed_code</span>
                <?= getenv("WORKS") ?>
            </li>
        </a>
    </ul>
</nav>