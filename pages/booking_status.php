
<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mechanic'){
    header("Location: index.php?page=login");
    exit;
}

$id = (int)$_GET['id'];
$status = $_GET['status'];

$allowed = ['done','canceled','in_progress'];

if(in_array($status, $allowed)){
    $stmt = $pdo->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->execute([$status, $id]);
}

header("Location: index.php?page=mechanic");
exit;