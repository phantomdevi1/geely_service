<?php
require_once 'includes/db.php';

$centers = $pdo->query("SELECT * FROM centers ORDER BY id")->fetchAll();
?>

<section class="service-centers">
<div class="container">

<h1>Сервисные центры Geely & Belgee</h1>
<p>Выберите ближайший сервисный центр и записывайтесь на обслуживание вашего автомобиля онлайн.</p>

<div class="centers-grid">

<?php foreach($centers as $center): ?>
<div class="center-card">

    <?php if(!empty($center['image'])): ?>
        <img src="<?= htmlspecialchars($center['image']) ?>" alt="<?= htmlspecialchars($center['name']) ?>">
    <?php endif; ?>

    <h3><?= htmlspecialchars($center['name']) ?></h3>

    <!-- карта -->
    <?php if(!empty($center['map_iframe'])): ?>
        <div class="map">
            <?= $center['map_iframe'] ?>
        </div>
    <?php endif; ?>

    <p>Адрес: <?= htmlspecialchars($center['address']) ?></p>
    <p>Телефон: <?= htmlspecialchars($center['phone']) ?></p>
    <p>Время работы: <?= substr($center['open_time'],0,5) ?> – <?= substr($center['close_time'],0,5) ?></p>

    <a href="index.php?page=booking&center_id=<?= $center['id'] ?>" class="btn-primary">
        Записаться
    </a>

</div>
<?php endforeach; ?>

</div>
</div>
</section>

