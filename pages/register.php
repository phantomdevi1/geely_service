<?php
session_start();
require_once 'includes/db.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if(!$name || !$phone || !$email || !$password || !$password2){
        $error = "Заполните все поля";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Введите корректный email";
    }
    elseif(!preg_match('/^\+?\d{10,15}$/',$phone)){
        $error = "Введите корректный номер телефона";
    }
    elseif($password !== $password2){
        $error = "Пароли не совпадают";
    }
    elseif(strlen($password) < 6){
        $error = "Пароль должен быть минимум 6 символов";
    }
    else{

        // проверяем существование пользователя
        $stmt = $pdo->prepare("SELECT id FROM users WHERE phone=? OR email=?");
        $stmt->execute([$phone,$email]);

        if($stmt->fetch()){
            $error = "Пользователь с таким телефоном или email уже существует";
        }
        else{

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users (name, phone, email, password_hash)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->execute([$name, $phone, $email, $password_hash]);

            $success = "Регистрация прошла успешно! Теперь вы можете войти.";
        }
    }
}
?>

<section class="login-page">

<div class="login-wrapper">

<h1>Регистрация</h1>
<p class="login-subtitle">Создайте аккаунт для записи на сервис</p>

<?php if($error): ?>
<div class="login-error"><?= $error ?></div>
<?php endif; ?>

<?php if($success): ?>
<div class="success-msg"><?= $success ?></div>
<?php endif; ?>

<form method="POST" class="login-form">

<div class="input-group">
<label>Имя</label>
<input type="text" name="name" required>
</div>

<div class="input-group">
<label>Телефон</label>
<input type="tel" name="phone" placeholder="+7XXXXXXXXXX" required>
</div>

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>Пароль</label>
<input type="password" name="password" required>
</div>

<div class="input-group">
<label>Повторите пароль</label>
<input type="password" name="password2" required>
</div>

<button type="submit" class="login-btn">
Зарегистрироваться
</button>

<p class="login-register">
Уже есть аккаунт?  
<a href="index.php?page=login">Войти</a>
</p>

</form>

</div>
</section>