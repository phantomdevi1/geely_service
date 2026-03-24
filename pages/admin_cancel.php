<?php
session_start();
require_once 'includes/db.php';

if($_SESSION['role'] !== 'admin'){
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("UPDATE bookings SET status='canceled' WHERE id=?");
$stmt->execute([$id]);

header("Location: index.php?page=admin");
exit;