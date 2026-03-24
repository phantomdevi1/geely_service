<?php
session_start();
require_once 'includes/db.php';

// Проверка авторизации
if(!isset($_SESSION['user_id'])){
    header("Location: index.php?page=login");
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Получаем записи пользователя
$stmt = $pdo->prepare("
SELECT 
    bookings.id,
    bookings.booking_datetime,
    services.name AS service_name,
    centers.name AS center_name,
    cars.brand,
    cars.model
FROM bookings
LEFT JOIN services ON bookings.service_id = services.id
LEFT JOIN centers ON bookings.center_id = centers.id
LEFT JOIN cars ON bookings.car_id = cars.id
WHERE bookings.user_id = ?
ORDER BY bookings.booking_datetime DESC
");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();

// Отмена записи
if(isset($_GET['cancel'])){
    $booking_id = (int)$_GET['cancel'];

    $stmt = $pdo->prepare("DELETE FROM bookings WHERE id=? AND user_id=?");
    $stmt->execute([$booking_id, $user_id]);

    header("Location: index.php?page=profile");
    exit;
}
?>

<section class="profile">
<div class="container">

<h1>Личный кабинет</h1>

<div class="profile-card">

<h2>Мои данные</h2>

<p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
<p><strong>Телефон:</strong> <?= htmlspecialchars($user['phone']) ?></p>

<a href="index.php?page=logout" class="btn-logout">Выйти</a>

</div>

<div class="profile-card">

<h2>Мои записи на сервис</h2>

<?php if(empty($bookings)): ?>

<p>У вас пока нет записей.</p>

<?php else: ?>

<table class="profile-table">

<thead>
<tr>
<th>Дата</th>
<th>Автомобиль</th>
<th>Услуга</th>
<th>Сервисный центр</th>
<th></th>
</tr>
</thead>

<tbody>

<?php foreach($bookings as $booking): ?>

<tr>

<td><?= date('d.m.Y H:i', strtotime($booking['booking_datetime'])) ?></td>

<td><?= htmlspecialchars($booking['brand'].' '.$booking['model']) ?></td>

<td><?= htmlspecialchars($booking['service_name']) ?></td>

<td><?= htmlspecialchars($booking['center_name']) ?></td>

<td>
<a href="index.php?page=profile&cancel=<?= $booking['id'] ?>" 
class="btn-cancel"
onclick="return confirm('Отменить запись?')">
Отменить
</a>
</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>

<?php endif; ?>

</div>

</div>
</section>