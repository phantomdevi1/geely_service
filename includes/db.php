<?php
// Настройки подключения
$host = 'localhost';       // обычно localhost
$db   = 'geely_service';   // имя вашей базы данных
$user = 'root';            // пользователь MySQL
$pass = '';                // пароль MySQL (оставьте пустым, если нет)
$charset = 'utf8mb4';      // кодировка для поддержки русских символов

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // вывод ошибок
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // удобный fetch
    PDO::ATTR_EMULATE_PREPARES   => false,                  // реальные подготовленные запросы
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // В рабочем проекте лучше логировать ошибку, а пользователю выдавать общую информацию
    exit('Ошибка подключения к базе данных: ' . $e->getMessage());
}