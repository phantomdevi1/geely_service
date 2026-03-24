<?php
session_start();

// текущая страница
$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Сервисный центр Geely & Belgee</title>

<link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body>

<header class="header">

<div class="container header-inner">

    <!-- Логотипы -->
    <div class="logos">
        <img src="images/geely-logo.png" alt="Geely">
        <img src="images/belgee-logo.png" alt="Belgee">
    </div>

    <!-- Навигация -->
    <nav class="nav">

        <a href="index.php?page=home" class="<?= ($page=='home') ? 'active' : '' ?>">
            Главная
        </a>

        <a href="index.php?page=services" class="<?= ($page=='services') ? 'active' : '' ?>">
            Сервисные центры
        </a>

        <a href="index.php?page=booking" class="<?= ($page=='booking') ? 'active' : '' ?>">
            Запись
        </a>

        <?php if(isset($_SESSION['user_id'])): ?>

            <?php if($_SESSION['role'] === 'admin'): ?>

                <a href="index.php?page=admin" class="<?= ($page=='admin') ? 'active' : '' ?>">
                    Админ
                </a>

            <?php elseif($_SESSION['role'] === 'mechanic'): ?>

                <a href="index.php?page=mechanic" class="<?= ($page=='mechanic') ? 'active' : '' ?>">
                    Панель механика
                </a>

            <?php else: ?>

                <a href="index.php?page=profile" class="<?= ($page=='profile') ? 'active' : '' ?>">
                    Личный кабинет
                </a>

            <?php endif; ?>

            <span class="user-name">
                <?= htmlspecialchars($_SESSION['user_name']) ?>
            </span>

        <?php else: ?>

            <a href="index.php?page=login" class="<?= ($page=='login') ? 'active' : '' ?>">
                Войти
            </a>

        <?php endif; ?>

    </nav>

</div>

</header>