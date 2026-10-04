<header>
    <a href="<?= getenv("HTML_ROOT_DIR") ?>">
        <h1><?= getenv("SITE_NAME") ?></h1>
    </a>
    <nav>
        <ul>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
                <li>
                    <p>
                        <?= getenv("ARTICLES") ?>
                        <span class="material-symbols-outlined">article</span>
                    </p>
                </li>
            </a>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                <li>
                    <p>
                        <?= getenv("WORKS") ?>
                        <span class="material-symbols-outlined">deployed_code</span>
                    </p>
                </li>
            </a>
        </ul>
    </nav>
</header>