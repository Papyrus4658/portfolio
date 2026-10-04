<footer>
    <nav>
        <ul>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
                <li data-en="Processes">
                    <p class="content_name">
                        <?= getenv("ARTICLES") ?>
                        <span class="material-symbols-outlined">article</span>
                    </p>
                </li>
            </a>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                <li data-en="Programs">
                    <p class="content_name">
                        <?= getenv("WORKS") ?>
                        <span class="material-symbols-outlined">deployed_code</span>
                    </p>
                </li>
            </a>
        </ul>
    </nav>
</footer>