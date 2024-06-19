<?php
    require_once "../vendor/autoload.php";
    use App\DB;
    session_start();
    $uid = $_SESSION["uid"] ?? 0;
    if ($uid) {
        $comment = $_POST["comment"];
        $pid = $_POST["pid"];
        $db = new DB();
        $date = (new DateTime())->format("Y-m-d");
        if ($db->add_comment($uid, $pid, $comment, $date)) {
            $_SESSION["message"] = "GOOD";
        }else {
            $_SESSION["message"] = "ERROR";
        }
    }
    header("Location: " . $_SERVER["HTTP_REFERER"]);