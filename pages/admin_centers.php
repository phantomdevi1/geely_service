<?php
session_start();
require_once 'includes/db.php';

if($_SESSION['role'] !== 'admin'){
    exit;
}

// добавление центра
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $address = $_POST['address'];

    $stmt = $pdo->prepare("INSERT INTO centers (name, address) VALUES (?, ?)");
    $stmt->execute([$name, $address]);
}

$centers = $pdo->query("SELECT * FROM centers")->fetchAll();
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Сервисные центры</h1>

<div class="admin-card">

<h2>Добавить центр</h2>

<form method="POST" style="display:flex; gap:10px; flex-wrap:wrap;">
<input type="text" name="name" placeholder="Название" required>
<input type="text" name="address" placeholder="Адрес" required>
<button class="btn btn-primary">Добавить</button>
</form>

</div>

<div class="admin-card">

<h2>Список центров</h2>

<table class="admin-table">

<?php foreach($centers as $c): ?>

<tr>
<td><?= htmlspecialchars($c['name']) ?></td>
<td><?= htmlspecialchars($c['address']) ?></td>
<td>
<a href="index.php?page=admin_edit_center&id=<?= $c['id'] ?>" class="btn btn-warning">
Редактировать
</a>

<a href="index.php?page=admin_delete_center&id=<?= $c['id'] ?>" class="btn btn-danger">
Удалить
</a>
</td>
</tr>

<?php endforeach; ?>

</table>

</div>

</div>
</section>