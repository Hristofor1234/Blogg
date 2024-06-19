<?php
require_once "../vendor/autoload.php";
use App\DB;
session_start();
$uid = $_SESSION["uid"] ?? 0;

if (isset($_SESSION["uid"], $_POST["pid"])) {
    $db = new DB();
    $db->delete_post($_POST["pid"]);
}

header("Location: " . $_SERVER["HTTP_REFERER"]);