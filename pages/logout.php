<?php
session_start();

// очищаем сессию
$_SESSION = [];
session_destroy();

// редирект на главную
header("Location: index.php");
exit;