<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php?page=login");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

// получаем запись
$stmt = $pdo->prepare("
SELECT 
    bookings.*,
    users.name,
    users.phone,
    services.name AS service_name,
    centers.name AS center_name
FROM bookings
LEFT JOIN users ON bookings.user_id = users.id
LEFT JOIN services ON bookings.service_id = services.id
LEFT JOIN centers ON bookings.center_id = centers.id
WHERE bookings.id = ?
");
$stmt->execute([$id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$booking){
    die("Запись не найдена");
}

// сохранение
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_date = $_POST['date'];

    $stmt = $pdo->prepare("UPDATE bookings SET booking_datetime=? WHERE id=?");
    $stmt->execute([$new_date, $id]);

    header("Location: index.php?page=admin");
    exit;
}
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Перенос записи</h1>

<div class="admin-card">

<!-- Информация о записи -->
<div class="booking-info">

<div>
<strong>Клиент:</strong><br>
<?= htmlspecialchars($booking['name']) ?><br>
<span class="muted"><?= htmlspecialchars($booking['phone']) ?></span>
</div>

<div>
<strong>Услуга:</strong><br>
<?= htmlspecialchars($booking['service_name']) ?>
</div>

<div>
<strong>Центр:</strong><br>
<?= htmlspecialchars($booking['center_name']) ?>
</div>

<div>
<strong>Текущая дата:</strong><br>
<?= date('d.m.Y H:i', strtotime($booking['booking_datetime'])) ?>
</div>

</div>

<hr>

<!-- Форма -->
<form method="POST" class="admin-form">

<label>Новая дата и время</label>
<input type="datetime-local" name="date" required>

<div class="form-actions">
<button class="btn btn-primary">Сохранить</button>
<a href="index.php?page=admin" class="btn btn-secondary">Отмена</a>
</div>

</form>

</div>

</div>
</section>