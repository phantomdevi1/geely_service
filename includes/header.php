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

<header class="header" id="header">

    <!-- ВЕРХНИЙ БАР -->
    <div class="header-top">
        <div class="container header-inner">

            <nav class="nav">

                <a href="index.php?page=home" class="<?= ($page=='home') ? 'active' : '' ?>">Главная</a>
                <a href="index.php?page=services" class="<?= ($page=='services') ? 'active' : '' ?>">Сервисы</a>
                <a href="index.php?page=booking" class="<?= ($page=='booking') ? 'active' : '' ?>">Запись</a>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <?php if($_SESSION['role'] === 'admin'): ?>
                        <a href="index.php?page=admin">Админ</a>
                    <?php elseif($_SESSION['role'] === 'mechanic'): ?>
                        <a href="index.php?page=mechanic">Механик</a>
                    <?php else: ?>
                        <a href="index.php?page=profile">Кабинет</a>
                    <?php endif; ?>

                    <span class="user-name">
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </span>

                <?php else: ?>
                    <a href="index.php?page=login">Войти</a>
                <?php endif; ?>

            </nav>

        </div>
    </div>

    <!-- БОЛЬШОЙ БЛОК -->
    <div class="header-hero">

        <div class="hero-content">

            <div class="hero-logos">
                <img src="images/geely-logo.png" alt="Geely">
                <img src="images/belgee-logo.png" alt="Belgee">
            </div>

            <h1>Сервис Geely & Belgee</h1>
            <p>Официальное обслуживание и диагностика автомобилей</p>

        </div>

    </div>

</header>

<script>
window.addEventListener('scroll', function(){
    const header = document.getElementById('header');

    if(window.scrollY > 100){
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>