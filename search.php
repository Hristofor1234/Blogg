<?php
    require_once "vendor/autoload.php";
    use App\DB;
    $db = new DB();
    if ($_GET["query"] ?? false) {
        $posts = $db->search_post($_GET["query"]);
        $posts = array_map(function ($post) {
            $striped = strip_tags($post["Content"]);
            $post["Preview"] = mb_substr($striped, 0, 150). (mb_strlen($striped) > 150 ? "..." : "");
            $post["Date"] = DateTime::createFromFormat("Y-m-d", $post["Date"])->format("d.m.Y");
            return $post;
        }, $posts);
    }
    else {
        $posts = [];
    }
?>

<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport"
          content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv = "X-UA-Compatible" content = "ie=edge">
    <title>Блог</title>
    <link rel = "stylesheet" href = "assets/css/common.css">
    <link rel = "stylesheet" href = "assets/css/search.css">
</head>
<body>
<script src="assets/js/common.js" defer></script>

<?php include "include/header.php"?>

<main>
    <div class="inner_container">
        <form action = "">
            <label>
                <input name="query" type = "text" placeholder="Я ищу..." value="<?= $_GET["query"] ?? "" ?>">
            </label>
        </form>
        <div class="results <?= !count($posts)? "not_found": "" ?>">
        <?php if (count($posts)): ?>
            <?php foreach ($posts as $post): ?>
            <div class="post">
                <div class="post_info">
                    <p class="user_name"><?= $post["User_name"] ?></p>
                    <p class="data"><?= $post["Date"] ?></p>
                </div>
                <h2><?= $post["Name"] ?></h2>
                <?php if ($post["Cover"]): ?>
                    <div class="cover">
                        <img src = "<?= $post["Cover"] ?>" alt = "">
                    </div>
                <?php endif; ?>
                <p class="preview"><?= $post["Preview"] ?></p>
                <a href="post.php?id=<?= $post["Id"] ?>">Читать</a>
                <div class="post_stats">
                    <div class = "stat">
                        <img src = "assets/images/view-eye-svgrepo-com.svg" alt = "">
                        <p><?= $post["Views"] ?></p>
                    </div>
                    <div class = "stat">
                        <img src = "assets/images/comment-1-svgrepo-com.svg" alt = "">
                        <p><?= $post["Comments"] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="not_found">
                <img src = "assets/images/not-found-error-alert-svgrepo-com.svg" alt = "">
                <p> По вашему запросу ничего не найденно!</p>
            </div>
        <?php endif; ?>
        </div>
    </div>
</main>

<?php include "include/footer.php"?>
</body>
</html>