<?php
session_start();
require_once 'includes/db.php';

// Проверка роли
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mechanic'){
    header("Location: index.php?page=login");
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем центр механика
$stmt = $pdo->prepare("SELECT center_id FROM users WHERE id=?");
$stmt->execute([$user_id]);
$mechanic = $stmt->fetch();

$center_id = $mechanic['center_id'];

// Получаем записи
$stmt = $pdo->prepare("
SELECT 
    bookings.*,
    COALESCE(users.name, bookings.name) AS client_name,
    COALESCE(users.phone, bookings.phone) AS client_phone,
    services.name AS service_name,
    centers.name AS center_name,
    cars.brand,
    cars.model
FROM bookings
LEFT JOIN users ON bookings.user_id = users.id
LEFT JOIN services ON bookings.service_id = services.id
LEFT JOIN centers ON bookings.center_id = centers.id
LEFT JOIN cars ON bookings.car_id = cars.id
WHERE bookings.center_id = ?
ORDER BY 
    CASE WHEN bookings.status = 'done' THEN 1 ELSE 0 END,
    bookings.booking_datetime DESC
");

$stmt->execute([$center_id]);
$bookings = $stmt->fetchAll();
?>

<section class="profile">
<div class="container">

<h1>Панель механика</h1>
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>Панель механика</h1>
    <a href="index.php?page=logout" class="btn-logout" onclick="return confirm('Вы точно хотите выйти из профиля?')">
        Выйти
    </a>
</div>

<table class="profile-table">

<thead>
<tr>
<th>Дата</th>
<th>Клиент</th>
<th>Авто</th>
<th>Услуга</th>
<th>Статус</th>
<th>Действие</th>
</tr>
</thead>

<tbody>

<?php foreach($bookings as $b): ?>

<tr>

<td><?= date('d.m.Y H:i', strtotime($b['booking_datetime'])) ?></td>

<td>
<?= htmlspecialchars($b['client_name']) ?><br>
<?= htmlspecialchars($b['phone']) ?>
</td>

<td><?= htmlspecialchars($b['brand'].' '.$b['model']) ?></td>

<td><?= htmlspecialchars($b['service_name']) ?></td>

<td><?= $b['status'] ?></td>

<td>
<a href="index.php?page=booking_status&id=<?= $b['id'] ?>&status=done" class="btn-done">✔</a>
<a href="index.php?page=booking_status&id=<?= $b['id'] ?>&status=canceled" class="btn-cancel">✖</a>
</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>

</div>
</section>