<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php?page=login");
    exit;
}

// Получаем все записи
$stmt = $pdo->query("
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
ORDER BY bookings.booking_datetime DESC
");

$bookings = $stmt->fetchAll();
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Админ-панель</h1>
    <a href="index.php?page=logout" class="btn-logout" onclick="return confirm('Вы точно хотите выйти из профиля?')">
        Выйти
    </a>

<div class="admin-card">

<h2>Все записи</h2>

<table class="admin-table">

<thead>
<tr>
<th>ID</th>
<th>Дата</th>
<th>Клиент</th>
<th>Авто</th>
<th>Услуга</th>
<th>Центр</th>
<th>Статус</th>
<th>Действия</th>
</tr>
</thead>

<tbody>

<?php foreach($bookings as $b): ?>

<tr>
<td><span class="booking-id">#<?= $b['id'] ?></span></td>

<td><?= date('d.m.Y H:i', strtotime($b['booking_datetime'])) ?></td>

<td>
<strong><?= htmlspecialchars($b['client_name']) ?></strong><br>
<span style="color:#666;"><?= htmlspecialchars($b['client_phone']) ?></span>
</td>

<td><?= htmlspecialchars(($b['brand'] ?? '—').' '.($b['model'] ?? '')) ?></td>

<td><?= htmlspecialchars($b['service_name']) ?></td>

<td><?= htmlspecialchars($b['center_name']) ?></td>

<td>
<span class="status status-<?= $b['status'] ?>">
<?= $b['status'] ?>
</span>
</td>

<td>
<a href="index.php?page=admin_edit&id=<?= $b['id'] ?>" class="btn btn-warning">Перенос</a>
<a href="index.php?page=admin_cancel&id=<?= $b['id'] ?>" class="btn btn-danger">Отмена</a>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<div class="admin-card">
<a href="index.php?page=admin_centers" class="btn btn-primary">
Управление сервисными центрами
</a>
<a href="index.php?page=admin_users" class="btn btn-primary">
Управление пользователями
</a>
</div>

</div>
</section>