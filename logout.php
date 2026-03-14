<?php
session_start();

if ($_SESSION["login"]) {
    unset($_SESSION["login"]);
    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
