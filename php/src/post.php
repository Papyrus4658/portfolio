<?php
include "dbconnect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $handle = htmlspecialchars($_POST["handle"], ENT_QUOTES, "UTF-8");
        $post = htmlspecialchars($_POST["post"], ENT_QUOTES, "UTF-8");
        $published_at = date("Y-m-d H:i:s");

        $sql = "INSERT INTO bbs (handle, post, published_at) VALUES (:handle, :post, :published_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":handle" => $handle,
            ":post" => $post,
            ":published_at" => $published_at
        ]);

        $_SESSION["register"] = "success";
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION["register"] = false;
    }
}

header("Location: ./bbs.php");
exit;
