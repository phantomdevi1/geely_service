<?php
session_start();
require_once 'includes/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: index.php?page=login");
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $text = trim($_POST['text']);
    $rating = (int)$_POST['rating'];

    if(!$text){
        $error = "Введите текст отзыва";
    }

    if(!$rating || $rating < 1 || $rating > 5){
        $rating = 5;
    }

    if(!$error){

        $stmt = $pdo->prepare("
            INSERT INTO reviews (user_id, name, rating, text)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $rating,
            $text
        ]);

        header("Location: index.php?page=home");
        exit;
    }
}
?>

<section class="form-page">
<div class="container">
<div class="add_reviews-block">
<h1>Оставить отзыв</h1>

<?php if($error): ?>
<div class="error-msg"><?= $error ?></div>
<?php endif; ?>

<form method="POST" class="review-form">

<label>Оценка</label>
<select name="rating" class="raiting-select">
<option value="5">5 ⭐</option>
<option value="4">4 ⭐</option>
<option value="3">3 ⭐</option>
<option value="2">2 ⭐</option>
<option value="1">1 ⭐</option>
</select>

<label>Отзыв</label>
<textarea name="text" class="raitting-textarea" required></textarea>

<button class="btn-primary">Отправить</button>

</form>
</div>
</div>
</section>