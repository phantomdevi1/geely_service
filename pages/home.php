<?php
session_start();
require_once 'includes/db.php';

?>

<section class="hero">

<div class="hero-overlay">

<div class="container hero-content">

<h1>Официальное обслуживание<br>Geely и Belgee <br> от Авто Премиум</h1>

<p>
Современный сервисный центр.  
Запись онлайн за 1 минуту.
</p>

<a class="btn-primary" href="index.php?page=booking">
Записаться на обслуживание
</a>

</div>

</div>

</section>


<section class="about">

<div class="container about-grid">

<div class="about-text">

<h2>Профессиональный сервис вашего автомобиля</h2>

<p>
Мы предоставляем полный спектр услуг обслуживания автомобилей
Geely и Belgee. Наши специалисты используют современное
оборудование и оригинальные запчасти.
</p>

<p>
Онлайн система записи позволяет выбрать удобное время
и избежать очередей.
</p>

</div>

<div class="stats">

<div class="stat">
<h3>10+</h3>
<p>лет опыта</p>
</div>

<div class="stat">
<h3>5000+</h3>
<p>обслуженных авто</p>
</div>

<div class="stat">
<h3>4.9</h3>
<p>рейтинг клиентов</p>
</div>

</div>

</div>

</section>


<section class="services">

<div class="container">

<h2>Наши услуги</h2>

<div class="services-grid">

<div class="service-card">

<h3>Техническое обслуживание</h3>
<p>Регламентное ТО автомобилей</p>

</div>

<div class="service-card">

<h3>Компьютерная диагностика</h3>
<p>Полная проверка систем автомобиля</p>

</div>

<div class="service-card">

<h3>Замена масла</h3>
<p>Быстрая и качественная замена</p>

</div>

<div class="service-card">

<h3>Ремонт подвески</h3>
<p>Диагностика и ремонт подвески</p>

</div>

</div>

</div>

</section>

<?php
$reviews = $pdo->query("
    SELECT 
        reviews.*,
        COALESCE(users.name, reviews.name) AS author
    FROM reviews
    LEFT JOIN users ON reviews.user_id = users.id
    ORDER BY created_at DESC
    LIMIT 10
")->fetchAll();
?>

<section class="reviews">
<div class="container">

<h2>Отзывы клиентов</h2>

<div class="reviews-slider">

<?php foreach($reviews as $r): ?>
<div class="review-card">

<div class="review-header">
<strong><?= htmlspecialchars($r['author']) ?></strong>
<span class="review-date">
<?= date('d.m.Y', strtotime($r['created_at'])) ?>
</span>
</div>

<div class="review-rating">
<?= str_repeat('⭐', $r['rating']) ?>
</div>

<p class="review-text">
<?= nl2br(htmlspecialchars($r['text'])) ?>
</p>

</div>
<?php endforeach; ?>

</div>

<!-- КНОПКА -->
<button class="btn-primary review-btn" onclick="handleReviewClick()">
Оставить отзыв
</button>

</div>
</section>


<section class="cta">

<div class="container-cta">

<h2>Запишитесь на сервис прямо сейчас</h2>

<p>Выберите удобное время онлайн</p>

<a href="index.php?page=booking" class="btn-primary-large">
Записаться
</a>

</div>

</section>

<script>
function handleReviewClick(){

    <?php if(!isset($_SESSION['user_id'])): ?>

        if(confirm("Отзывы могут оставлять только авторизованные пользователи.\nПерейти к авторизации?")){
            window.location.href = "index.php?page=login";
        }

    <?php else: ?>

        window.location.href = "index.php?page=add_review";

    <?php endif; ?>

}
</script>