<header>
    <h1>
        <?php
        if ($page === "process") {
            echo $row["title"];
        } elseif ($page === "programs") {
            echo "Programs";
        } else {
            echo "Processes";
        }
        ?>
    </h1>
    <nav class="contents">
        <ul>
            <li><a href="<?= getenv("HTML_ROOT_DIR") ?>index.php">Processes</a></li>
            <li><a href="<?= getenv("HTML_ROOT_DIR") ?>programs.php">Programs</a></li>
            <li><a href="https://codeberg.org/rogue2651/portfolio">Prototype</a></li>
        </ul>
    </nav>
</header>