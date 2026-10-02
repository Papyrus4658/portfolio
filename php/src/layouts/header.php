<header>
    <h1><?= getenv("SITE_NAME") ?></h1>
    <nav class="contents">
        <ul>
            <li>
                <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
                    <?= getenv("ARTICLES") ?>
                </a>
            </li>
            <li>
                <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                    <?= getenv("WORKS") ?>
                </a>
            </li>
            <li>
                <a href="https://codeberg.org/rogue2651/portfolio">
                    <?= getenv("SOURCECODE") ?>
                </a>
            </li>
        </ul>
    </nav>
</header>