<?php
session_start();
require_once 'includes/db.php';

// Авторизация
$authorized = $_SESSION['user_logged'] ?? false;
$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? '';
$user_phone = $_SESSION['user_phone'] ?? '';
$user_car_id = $_SESSION['user_car_id'] ?? '';

$message = '';
$errors = [];

// Получаем данные для формы
$cars = $pdo->query("SELECT * FROM cars ORDER BY brand, model")->fetchAll();
$services = $pdo->query("SELECT * FROM services ORDER BY name")->fetchAll();
$centers = $pdo->query("SELECT * FROM centers ORDER BY name")->fetchAll();

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'] ?? '';
    $service_id = $_POST['service_id'] ?? '';
    $center_id = $_POST['center_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // ===== Валидация =====
    if (!$car_id) $errors[] = "Выберите автомобиль";
    if (!$service_id) $errors[] = "Выберите услугу";
    if (!$center_id) $errors[] = "Выберите сервисный центр";
    if (!$date) $errors[] = "Выберите дату";
    if (!$time) $errors[] = "Выберите время";
    if (!$name) $errors[] = "Введите имя";
    if (!$phone || !preg_match('/^\+?\d{10,15}$/', $phone)) $errors[] = "Введите корректный номер телефона (+7XXXXXXXXXX)";

    $booking_datetime = $date . ' ' . $time . ':00';

    // Проверка занятости (дополнительно, на всякий случай)
    if ($center_id && $date && $time) {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE center_id=? AND booking_datetime=?");
        $stmt_check->execute([$center_id, $booking_datetime]);
        if ($stmt_check->fetchColumn() > 0) {
            $errors[] = "Это время уже занято. Выберите другое.";
        }
    }

    // Сохраняем запись
    if (empty($errors)) {
        $stmt_insert = $pdo->prepare("INSERT INTO bookings 
            (user_id, car_id, service_id, center_id, booking_datetime, name, phone)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->execute([$user_id, $car_id, $service_id, $center_id, $booking_datetime, $name, $phone]);
        $message = "Спасибо, $name! Ваша запись на $booking_datetime принята.";
    }
}

// Выбранный центр и дата
$selected_center_id = $_POST['center_id'] ?? $centers[0]['id'];
$selected_date = $_POST['date'] ?? date('Y-m-d');

// Получаем рабочее время центра
$center_stmt = $pdo->prepare("SELECT open_time, close_time FROM centers WHERE id = ?");
$center_stmt->execute([$selected_center_id]);
$center_time = $center_stmt->fetch();
$open_hour = (int)substr($center_time['open_time'],0,2);
$close_hour = (int)substr($center_time['close_time'],0,2);

// Получаем занятые часы
$stmt_booked = $pdo->prepare("
    SELECT TIME(booking_datetime) as booked_time
    FROM bookings
    WHERE center_id=? AND DATE(booking_datetime)=?
");
$stmt_booked->execute([$selected_center_id, $selected_date]);
$booked_times = $stmt_booked->fetchAll(PDO::FETCH_COLUMN);

// Генерируем доступные часы
$available_hours = [];
for($h=$open_hour; $h<$close_hour; $h++){
    $hour_str = sprintf("%02d:00:00",$h); // для сравнения с booked_times
    if(!in_array($hour_str, $booked_times)){
        $available_hours[] = sprintf("%02d:00",$h); // для select
    }
}

// Получаем услуги для таблицы
$services_for_table = $pdo->query("SELECT name, recommended_mileage, price FROM services ORDER BY id")->fetchAll();
?>

<section class="booking">
<div class="container">

<h1>Запись на обслуживание</h1>

<?php if(!empty($message)): ?>
    <div class="success-msg"><?= $message ?></div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
    <div class="error-msg">
        <ul>
        <?php foreach($errors as $err): ?>
            <li><?= $err ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="index.php?page=booking" method="POST" class="booking-form">

    <label>Автомобиль</label>
    <select name="car_id" required>
        <option value="">Выберите автомобиль</option>
        <?php foreach($cars as $car): ?>
        <option value="<?= $car['id'] ?>" <?= ($car['id']==$user_car_id)?'selected':'' ?>>
            <?= htmlspecialchars($car['brand'].' '.$car['model']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <label>Услуга</label>
    <select name="service_id" required>
        <option value="">Выберите услугу</option>
        <?php foreach($services as $s): ?>
        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name'].' — '.$s['price'].'₽') ?></option>
        <?php endforeach; ?>
    </select>

    <label>Сервисный центр</label>
    <select name="center_id" required onchange="this.form.submit()">
        <option value="">Выберите центр</option>
        <?php foreach($centers as $c): ?>
        <option value="<?= $c['id'] ?>" <?= ($c['id']==$selected_center_id)?'selected':'' ?>>
            <?= htmlspecialchars($c['name']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <label>Дата</label>
    <input type="date" name="date" required value="<?= htmlspecialchars($selected_date) ?>">

    <label>Время</label>
    <select name="time" required>
        <option value="">Выберите время</option>
        <?php foreach($available_hours as $hour): ?>
            <option value="<?= $hour ?>" <?= (isset($_POST['time']) && $_POST['time']==$hour)?'selected':'' ?>>
                <?= $hour ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Имя</label>
    <input type="text" name="name" required value="<?= htmlspecialchars($user_name) ?>">

    <label>Телефон</label>
    <input type="tel" name="phone" pattern="^\+?\d{10,15}$" required value="<?= htmlspecialchars($user_phone) ?>" placeholder="+7XXXXXXXXXX">

    <button type="submit" class="btn-primary">Записаться</button>
</form>

<h2>Рекомендуемые услуги по пробегу</h2>
<table class="services-table">
    <thead>
        <tr>
            <th>Услуга</th>
            <th>Рекомендованный пробег / период</th>
            <th>Цена, ₽</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($services_for_table as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['recommended_mileage']) ?></td>
            <td><?= htmlspecialchars($s['price']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
</section>