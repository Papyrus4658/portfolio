<?php
$dsn = "mysql:host=" . getenv('HOSTNAME') . ";dbname=" . getenv('MARIADB_DATABASE');

try {
    $pdo = new PDO($dsn, getenv('MARIADB_USER'), getenv('MARIADB_PASSWORD'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "DB接続失敗";
}