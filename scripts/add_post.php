<?php
    require_once "../vendor/autoload.php";
    use App\DB;
    session_start();
    if (isset($_SESSION["uid"])) {
        $uid = $_SESSION["uid"];
        $name = $_POST["name"];
        $cover = $_POST["cover"];
        $text = $_POST["text"];
        $tags = explode(",", $_POST["tags"]);
        $tags = array_map(function ($tag) {
            return trim($tag);
        }, $tags);
        $tags = array_unique($tags);
        $tags = implode(",", $tags);
        $date = (new DateTime())->format("Y-m-d");
        $db = new DB();
        if ($db->add_post($date, $uid, $name, $cover, $text, $tags)) {
            $_SESSION["message"] = "POST DOBAVLEN";
        }
        else {
            $_SESSION["message"] = "POST NE DOBAVLEN";
        }
    }