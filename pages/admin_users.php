<?php
session_start();
require_once 'includes/db.php';

if($_SESSION['role'] !== 'admin'){
    exit;
}

// получаем пользователей (с центрами)
$stmt = $pdo->query("
SELECT users.*, centers.name AS center_name
FROM users
LEFT JOIN centers ON users.center_id = centers.id
ORDER BY users.id DESC
");

$users = $stmt->fetchAll();
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Управление пользователями</h1>

<div class="admin-card">

<table class="admin-table">

<tr>
<th>Имя</th>
<th>Телефон</th>
<th>Роль</th>
<th>Центр</th>
<th></th>
</tr>

<?php foreach($users as $u): ?>

<tr>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['phone']) ?></td>
<td><?= $u['role'] ?></td>
<td><?= htmlspecialchars($u['center_name'] ?? '—') ?></td>

<td>
<a href="index.php?page=admin_edit_user&id=<?= $u['id'] ?>" class="btn btn-warning">
Редактировать
</a>
</td>
</tr>

<?php endforeach; ?>

</table>

</div>

</div>
</section>