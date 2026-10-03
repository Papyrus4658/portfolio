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
                    <p><?= getenv("ARTICLES") ?></p>
                    <p>記事</p>
                </li>
            </a>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                <li>
                    <p><?= getenv("WORKS") ?></p>
                    <p>作品</p>
                </li>
            </a>
            <a href="https://codeberg.org/rogue2651/portfolio" target="_blank">
                <li>
                    <p><?= getenv("SOURCECODE") ?></p>
                    <p>サイトのソースコード</p>
                </li>
            </a>
        </ul>
    </nav>
</header>