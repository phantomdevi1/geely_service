<?php
session_start();
require_once 'includes/db.php';

if($_SESSION['role'] !== 'admin'){
    exit;
}

$id = (int)$_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_date = $_POST['date'];

    $stmt = $pdo->prepare("UPDATE bookings SET booking_datetime=? WHERE id=?");
    $stmt->execute([$new_date, $id]);

    header("Location: index.php?page=admin");
    exit;
}
?>

<form method="POST">
    <h2>Перенос записи</h2>
    <input type="datetime-local" name="date" required>
    <button class="btn-primary">Сохранить</button>
</form>