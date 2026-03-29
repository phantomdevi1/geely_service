<?php
session_start();
require_once 'includes/db.php';

if($_SESSION['role'] !== 'admin'){
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch();

$centers = $pdo->query("SELECT id, name FROM centers")->fetchAll();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $center_id = $_POST['center_id'] ?: null;

    $stmt = $pdo->prepare("
        UPDATE users SET name=?, phone=?, role=?, center_id=? WHERE id=?
    ");

    $stmt->execute([$name, $phone, $role, $center_id, $id]);

    header("Location: index.php?page=admin_users");
    exit;
}
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Редактирование пользователя</h1>

<div class="admin-card">

<form method="POST" class="admin-form">

<input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
<input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

<select name="role">
<option value="client" <?= $user['role']=='client'?'selected':'' ?>>Клиент</option>
<option value="mechanic" <?= $user['role']=='mechanic'?'selected':'' ?>>Механик</option>
<option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Админ</option>
</select>

<select name="center_id">
<option value="">Без центра</option>
<?php foreach($centers as $c): ?>
<option value="<?= $c['id'] ?>" <?= $user['center_id']==$c['id']?'selected':'' ?>>
<?= htmlspecialchars($c['name']) ?>
</option>
<?php endforeach; ?>
</select>

<button class="btn btn-primary">Сохранить</button>

</form>

</div>

</div>
</section>