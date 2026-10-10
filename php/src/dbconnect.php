<?php
$dsn = "mysql:host=" . getenv("MARIADB_HOST") . ";dbname=" . getenv("MARIADB_DATABASE");

try {
    $pdo = new PDO($dsn, getenv("MARIADB_USER"), getenv("MARIADB_PASSWORD"), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("現在アクセスできません。");
}