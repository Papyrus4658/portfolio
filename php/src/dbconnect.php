<?php
$dsn = "mysql:host=" . getenv("DB_HOST") . ";dbname=" . getenv("DB_DATABASE");

try {
    $pdo = new PDO($dsn, getenv("DB_USER"), getenv("DB_PASSWORD"), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "DB接続失敗";
}