<header>
    <h1>
        <a href="<?= getenv("HTML_ROOT_DIR") ?>">
            <?= getenv("SITE_NAME") ?>
        </a>
    </h1>
    <nav>
        <ul>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
                <li>
                    <?= getenv("ARTICLES") ?>
                </li>
            </a>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                <li>
                    <?= getenv("WORKS") ?>
                </li>
            </a>
            <a href="https://codeberg.org/rogue2651/portfolio" target="_blank">
                <li>
                    <?= getenv("SOURCECODE") ?>
                </li>
            </a>
        </ul>
    </nav>
</header>