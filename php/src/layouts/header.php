<header>
    <a href="<?= getenv("HTML_ROOT_DIR") ?>">
        <h1><?= getenv("SITE_NAME") ?></h1>
    </a>
    <nav>
        <ul>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">
                <li data-en="Processes">
                    <!-- <p><?= getenv("ARTICLES") ?></p> -->
                    <p class="content_name">
                        学習の記録
                        <span class="material-symbols-outlined">article</span>
                    </p>
                </li>
            </a>
            <a href="<?= getenv("HTML_ROOT_DIR") ?>works.php">
                <li data-en="Programs">
                    <!-- <p><?= getenv("WORKS") ?></p> -->
                    <p class="content_name">
                        作った作品
                        <span class="material-symbols-outlined">deployed_code</span>
                    </p>
                </li>
            </a>
            <a href="https://codeberg.org/rogue2651/portfolio" target="_blank">
                <li data-en="Prototype">
                    <!-- <p><?= getenv("SOURCECODE") ?></p> -->
                    <p class="content_name">
                        サイトのソースコード
                        <span class="material-symbols-outlined">open_in_new</span>
                    </p>
                </li>
            </a>
        </ul>
    </nav>
</header>