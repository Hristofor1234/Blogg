<?php
    require_once "../vendor/autoload.php";
    use App\DB;
    if (isset($_POST["login"], $_POST["password"])) {
        $db = new DB();
        session_start();
        $user = $db->get_user_by_login($_POST["login"]);
        if(count($user)) {
            $password = $user["Password"];
            if(password_verify($_POST["password"], $password)) {
                $_SESSION["uid"] = $user["Id"];
            }
            else {
                $_SESSION["message"] = "NE PRAVILNO parol";
            }
        }
        else {
            $_SESSION["message"] = "NE PRAVILNO login";
        }
    }
    header("Location: " . $_SERVER["HTTP_REFERER"]);