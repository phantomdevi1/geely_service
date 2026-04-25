<?php
session_start();
require_once 'includes/db.php';

$booking_id = $_GET['id'] ?? null;

if (!$booking_id) {
    header("Location: index.php?page=booking");
    exit;
}

$stmt = $pdo->prepare("
SELECT 
    b.*,
    c.name AS center_name,
    c.address AS center_address,
    s.name AS service_name,
    car.brand,
    car.model
FROM bookings b
LEFT JOIN centers c ON b.center_id = c.id
LEFT JOIN services s ON b.service_id = s.id
LEFT JOIN cars car ON b.car_id = car.id
WHERE b.id = ?
");

$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) {
    echo "Запись не найдена";
    exit;
}
?>

<section class="success-page">
<div class="container">
<center>
<div class="success-card">

<h1>✅ Запись подтверждена</h1>

<p class="success-text">
Ваша заявка успешно создана. Сохраните эту страницу или сделайте скриншот.
</p>

<div class="ticket">

<p><strong>Номер заявки:</strong> #<?= $booking['id'] ?></p>
<p><strong>Дата и время:</strong> <?= date('d.m.Y H:i', strtotime($booking['booking_datetime'])) ?></p>

<p><strong>Автомобиль:</strong> <?= htmlspecialchars($booking['brand'].' '.$booking['model']) ?></p>
<p><strong>Услуга:</strong> <?= htmlspecialchars($booking['service_name']) ?></p>

<p><strong>Сервисный центр:</strong> <?= htmlspecialchars($booking['center_name']) ?></p>
<p><strong>Адрес:</strong> <?= htmlspecialchars($booking['center_address']) ?></p>

</div>

<?php if(empty($_SESSION['user_id'])): ?>
<div class="notice">
<p>
💡 Зарегистрируйтесь на сайте, чтобы отслеживать свои записи, получать уведомления и быстрее записываться в следующий раз.
</p>
</div>
<?php endif; ?>

<a href="index.php" class="btn-primary">На главную</a>

</div>
</center>
</div>
</section>