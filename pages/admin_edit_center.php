<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header("Location: index.php?page=login");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

// Получаем центр
$stmt = $pdo->prepare("SELECT * FROM centers WHERE id=?");
$stmt->execute([$id]);
$center = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$center){
    die("Центр не найден");
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $map = $_POST['map_iframe'];

    $image = $center['image'];

    // 📤 Загрузка файла
    if(!empty($_FILES['image_file']['name'])){

        $file = $_FILES['image_file'];

        if($file['error'] === 0){

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','webp'];

            if(!in_array($ext, $allowed)){
                $error = "Допустимы только JPG, PNG, WEBP";
            } else {

                $new_name = 'center_' . time() . '.' . $ext;
                $upload_path = 'images/' . $new_name;

                if(move_uploaded_file($file['tmp_name'], $upload_path)){

                    // удалить старое изображение (если есть)
                    if(!empty($center['image']) && file_exists($center['image'])){
                        unlink($center['image']);
                    }

                    $image = $upload_path;
                } else {
                    $error = "Ошибка загрузки файла";
                }
            }
        }
    }

    if(!$error){
        $stmt = $pdo->prepare("
            UPDATE centers 
            SET name=?, address=?, phone=?, open_time=?, close_time=?, image=?, map_iframe=? 
            WHERE id=?
        ");

        $stmt->execute([
            $name, $address, $phone,
            $open_time, $close_time,
            $image, $map, $id
        ]);

        header("Location: index.php?page=admin_centers");
        exit;
    }
}
?>

<section class="admin-container">
<div class="container">

<h1 class="admin-title">Редактирование сервисного центра</h1>

<div class="admin-card">

<?php if($error): ?>
<div class="form-error"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="admin-form">

<div class="form-grid">

<!-- Левая колонка -->
<div>

<label>Название центра</label>
<input type="text" name="name" value="<?= htmlspecialchars($center['name']) ?>" required>

<label>Адрес</label>
<input type="text" name="address" value="<?= htmlspecialchars($center['address']) ?>" required>

<label>Телефон</label>
<input type="text" name="phone" value="<?= htmlspecialchars($center['phone']) ?>">

<label>Время открытия</label>
<input type="time" name="open_time" value="<?= $center['open_time'] ?>">

<label>Время закрытия</label>
<input type="time" name="close_time" value="<?= $center['close_time'] ?>">

</div>

<!-- Правая колонка -->
<div>

<label>Фото центра</label>

<?php if(!empty($center['image'])): ?>
    <img src="<?= htmlspecialchars($center['image']) ?>" class="preview-img" id="preview">
<?php else: ?>
    <img src="" class="preview-img" id="preview" style="display:none;">
<?php endif; ?>

<input type="file" name="image_file" accept="image/*" onchange="previewImage(event)">

<label>Карта (iframe)</label>
<textarea name="map_iframe"><?= htmlspecialchars($center['map_iframe']) ?></textarea>

</div>

</div>

<button class="btn btn-primary" style="margin-top:20px;">
Сохранить изменения
</button>

</form>

</div>

</div>
</section>

<script>
function previewImage(event){
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>