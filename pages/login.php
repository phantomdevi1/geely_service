<?php
session_start();
require_once 'includes/db.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if(!$phone || !$password){
        $error = "Введите телефон и пароль";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone=?");
        $stmt->execute([$phone]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password_hash'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_phone'] = $user['phone'];

            header("Location: index.php?page=profile");
            exit;

        } else {
            $error = "Неверный телефон или пароль";
        }

    }
}
?>

<section class="login-page">

<div class="login-wrapper">

<h1>Вход в личный кабинет</h1>
<p class="login-subtitle">Сервис Geely & Belgee</p>

<?php if($error): ?>
<div class="login-error"><?= $error ?></div>
<?php endif; ?>

<form method="POST" class="login-form">

<div class="input-group">
<label>Телефон</label>
<input type="tel" name="phone" placeholder="+7XXXXXXXXXX" required>
</div>

<div class="input-group">
<label>Пароль</label>
<input type="password" name="password" required>
</div>

<button type="submit" class="login-btn">
Войти
</button>

<p class="login-register">
Нет аккаунта?  
<a href="index.php?page=register">Зарегистрироваться</a>
</p>

</form>

</div>

</section>