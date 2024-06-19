<?php
namespace App;

use mysqli;

class DB {
    public $link;

    public function __construct() {
        $this->link = new mysqli("localhost", "root", "", "pract_blog");
    }

    private function escape_all(&...$params) {
        foreach ($params as &$param) {
            $param = $this->link->real_escape_string($param);
        }
    }

    public function check_new_login($login) {
        $this->escape_all($login);
        $user = $this->link->query("SELECT * FROM `users` WHERE `Login` = '$login'");
        return $user && $user->num_rows;
    }

    public function add_user($login, $password, $name) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $this->escape_all($login, $password, $name);
        $this->link->query("INSERT INTO `users` (`Login`, `Password`, `Name`) VALUES ('$login', '$password', '$name');");
    }

    public function get_user_by_login($login) {
        $this->escape_all($login);
        $user = $this->link->query("SELECT * FROM `users` WHERE `Login` = '$login'");
        if ($user && $user->num_rows) {
            return $user->fetch_assoc();
        }
        return [];
    }
    public function add_post($date, $uid, $name, $cover, $text, $tags) {
        $this->escape_all($date, $uid, $name, $cover, $text, $tags);
        $this->link->query(
            "INSERT INTO `posts` (`Date`, `Uid`,`Name`, `Cover`, `Content`, `Views`, `Tags`) 
                     VALUES ('$date', $uid,'$name', '$cover', '$text', 0, '$tags')"
        );
        return $this->link->errno === 0;
    }

    public function get_all_posts() {
        $posts = $this->link->query(
            "SELECT `u`.`Name` AS `User_name`, `p`.* FROM `posts` `p`
                    LEFT JOIN `users` `u` on `u`.Id = `p`.`Uid`
                     ORDER BY `p`.`Id` DESC");
        if ($posts && $posts->num_rows) {
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            return array_map(function ($post) {
                $post["Comments"] = $this->link->query(
                    "SELECT * FROM `comments` WHERE `Pid` = {$post["Id"]}")->num_rows;
                return $post;
            }, $posts);
        }
        return [];
    }

    public function get_filter_post($tag) {
        $this->escape_all($tag);
        $posts = $this->link->query(
            "SELECT `u`. `Name` AS `User_name`, `p`.* FROM `posts` `p`
                    LEFT JOIN `users` `u` on `u`.Id = `p`.`Uid`
                    WHERE `p`.`Tags` LIKE '%,$tag,%' OR `p`.`Tags` LIKE '$tag,%' OR `p`.`Tags` LIKE '%,$tag' OR `p`.`Tags` = '$tag'
                     ORDER BY `p`.`Id` DESC");
        if ($posts && $posts->num_rows) {
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            return array_map(function ($post) {
                $post["Comments"] = $this->link->query(
                    "SELECT * FROM `comments` WHERE `Pid` = {$post["Id"]}")->num_rows;
                return $post;
            }, $posts);
        }
        return [];
    }

    public function get_post_by_id($id) {
        $this->escape_all($id);
        $post = $this->link->query(
            "SELECT `u`. `Name` AS `User_name`, `p`.* FROM `posts` `p`
                    LEFT JOIN `users` `u` on `u` .Id = `p`.`Uid` WHERE `p`. `Id` = $id");
        if ($post && $post->num_rows) {
            return $post->fetch_assoc();
        }
        return [];
    }

    public function get_post_comments($pid) {
        $this->escape_all($pid);
        $comments = $this->link->query(
            "SELECT `c`.*, `u`. `Name` AS `User_name` FROM `comments` `c`
                    LEFT JOIN `users` `u` on `u`. `Id` = `c`. `Uid`
                    WHERE `c`. `Pid` = $pid ORDER BY  `c`.`Id` DESC");
            if ($comments && $comments->num_rows) {
                return $comments->fetch_all(MYSQLI_ASSOC);
            }
            return [];
    }

    public function add_comment($uid, $pid,  $comment, $date) {
        $this->escape_all($uid, $pid,  $comment, $date);
        $this->link->query("INSERT INTO `comments` (`Uid`, `Pid`, `Date`, `Text`) VALUES ($uid, $pid, '$date', '$comment')");
        return $this->link->errno === 0;
    }

    public function post_views($pid) {
        $this->escape_all($pid);
        $this->link->query("UPDATE `posts` SET `Views` = `Views` + 1 WHERE `Id` = $pid");
    }

    public function get_tranding() {
        $posts = $this->link->query("SELECT * FROM `posts` ORDER BY `Views` DESC LIMIT 0,3");
        if ($posts && $posts->num_rows) {
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            return array_map(function ($post) {
                $post["Comments"] = $this->link->query(
                    "SELECT * FROM `comments` WHERE `Pid` = {$post["Id"]}")->num_rows;
                return $post;
            }, $posts);
        }
        return [];
    }

    public function search_post($query) {
        $this->escape_all($query);
        $posts = $this->link->query(
            "SELECT `u`.`Name` AS `User_name`, `p`.* FROM `posts` `p`
                    LEFT JOIN `users` `u` on `u`.Id = `p`.`Uid`
                    WHERE `p`.`Name` LIKE '%$query%'
                     ORDER BY `p`.`Id` DESC");
        if ($posts && $posts->num_rows) {
            $posts = $posts->fetch_all(MYSQLI_ASSOC);
            return array_map(function ($post) {
                $post["Comments"] = $this->link->query(
                    "SELECT * FROM `comments` WHERE `Pid` = {$post["Id"]}")->num_rows;
                return $post;
            }, $posts);
        }
        return [];
    }

    public function delete_post ($id) {
        $this->escape_all($id);
        $this->link->query("DELETE FROM `posts` WHERE `Id` = $id");
        return [];
    }
}
