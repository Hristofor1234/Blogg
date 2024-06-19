<?php
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if (isset($_SESSION["message"])) {
        $message = $_SESSION["message"];
        unset($_SESSION["message"]);
    }
    $uid = $_SESSION["uid"] ?? 0;
?>

<header>
    <div class="inner_container">
        <button class="toggle_menu">
            <img src = "assets/images/burger-menu-svgrepo-com.svg" alt = "">
        </button>
        <nav>
            <ul>
                <li>
                    <a href = "index.php">Все</a>
                </li>
                <li>
                    <a href = "index.php?filter=Разработка">Разработка</a>
                </li>
                <li>
                    <a href = "index.php?filter=Дизайн">Дизайн</a>
                </li>
                <li>
                    <a href = "index.php?filter=Администрирование">Администрирование</a>
                </li>
            <?php if ($uid): ?>
                <li>
                    <a href = "scripts/logout.php">Выход</a>
                </li>
            <?php endif; ?>
            </ul>
        </nav>
        <div class="icons">
            <a href = "search.php">
                <img src = "assets/images/search-svgrepo-com.svg" alt = "">
            </a>
            <a href = "user.php">
                <img src = "assets/images/user-svgrepo-com.svg" alt = "">
            </a>
        </div>
    </div>
</header>

<div id="popup_message" class="<?= isset($message)? "active": ""?>">
    <div class="center">
        <p><?= $message ?? "" ?></p>
    </div>
</div>