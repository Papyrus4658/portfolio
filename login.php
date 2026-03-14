<?php
require("dbconnect.php");
session_start();

if ($_SESSION["login"]) {
    header("Location: index.php");
    exit;
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $st = $db->prepare("SELECT * FROM members WHERE email=? AND enrolled=1");
        $st->execute([nt($_POST["email"])]);
        $user = $st->fetch();

        if ($user) {
            if (password_verify($_POST["password"], $user["password"])) {
                $_SESSION["login"] = $user["id"];
                header("Location: index.php");
                exit;
            } else {
                $error_message = "ログインIDまたはパスワードが違います。";
                $_SESSION["error_message"] = $error_message;

                header("Location: index.php");
                exit;
            }
        } else {
            header("Location: index.php");
            exit;
        }
    }
}
