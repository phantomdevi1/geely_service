<?php
// Определяем текущую страницу
$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Сервисный центр Geely & Belgee</title>

<!-- CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- Favicon -->
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
        <a href="index.php?page=home" class="<?= ($page=='home') ? 'active' : '' ?>">Главная</a>
        <a href="index.php?page=services" class="<?= ($page=='services') ? 'active' : '' ?>">Сервисные центры</a>
        <a href="index.php?page=booking" class="<?= ($page=='booking') ? 'active' : '' ?>">Запись</a>
        <a href="index.php?page=profile" class="<?= ($page=='profile') ? 'active' : '' ?>">Личный кабинет</a>
    </nav>

</div>

</header>