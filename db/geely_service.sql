-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2026 г., 13:38
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `geely_service`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `car_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `booking_datetime` datetime NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('new','in_progress','done','canceled') COLLATE utf8mb4_unicode_ci DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `service_id`, `center_id`, `booking_datetime`, `name`, `phone`, `created_at`, `status`) VALUES
(1, 2, 22, 8, 3, '2026-03-27 19:00:00', 'Илья', '89607092738', '2026-03-24 13:12:36', 'done'),
(2, 4, 23, 8, 3, '2026-03-24 20:00:00', 'Администратор', '+79990000001', '2026-03-24 13:36:51', 'new'),
(4, NULL, 2, 2, 3, '2026-04-21 15:00:00', 'Илья', '89607092738', '2026-04-21 09:41:54', 'new');

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `created_at`) VALUES
(1, 'Geely', 'Atlas', '2026-03-10 10:00:58'),
(2, 'Geely', 'Atlas Pro', '2026-03-10 10:00:58'),
(3, 'Geely', 'Azkarra', '2026-03-10 10:00:58'),
(4, 'Geely', 'Binrui', '2026-03-10 10:00:58'),
(5, 'Geely', 'Binyue', '2026-03-10 10:00:58'),
(6, 'Geely', 'Boyue', '2026-03-10 10:00:58'),
(7, 'Geely', 'Boyue Cool', '2026-03-10 10:00:58'),
(8, 'Geely', 'Boyue L', '2026-03-10 10:00:58'),
(9, 'Geely', 'Coolray', '2026-03-10 10:00:58'),
(10, 'Geely', 'Emgrand', '2026-03-10 10:00:58'),
(11, 'Geely', 'Emgrand L', '2026-03-10 10:00:58'),
(12, 'Geely', 'Emgrand S', '2026-03-10 10:00:58'),
(13, 'Geely', 'Geometry C', '2026-03-10 10:00:58'),
(14, 'Geely', 'GX3 Pro', '2026-03-10 10:00:58'),
(15, 'Geely', 'Icon', '2026-03-10 10:00:58'),
(16, 'Geely', 'Jiaji', '2026-03-10 10:00:58'),
(17, 'Geely', 'Monjaro', '2026-03-10 10:00:58'),
(18, 'Geely', 'Okavango', '2026-03-10 10:00:58'),
(19, 'Geely', 'Preface', '2026-03-10 10:00:58'),
(20, 'Geely', 'Vision X6 Pro', '2026-03-10 10:00:58'),
(21, 'Geely', 'EX5', '2026-03-10 10:00:58'),
(22, 'Belgee', 'X50', '2026-03-10 10:00:58'),
(23, 'Belgee', 'X70', '2026-03-10 10:00:58'),
(24, 'Belgee', 'S50', '2026-03-10 10:00:58');

-- --------------------------------------------------------

--
-- Структура таблицы `centers`
--

CREATE TABLE `centers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `open_time` time NOT NULL DEFAULT '10:00:00',
  `close_time` time NOT NULL DEFAULT '20:00:00',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_iframe` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `centers`
--

INSERT INTO `centers` (`id`, `name`, `address`, `phone`, `created_at`, `open_time`, `close_time`, `image`, `map_iframe`) VALUES
(3, 'Geely & BelGee Тверь – Южный обход', 'ТПЗ Боровлёво-1, 164-й км трассы «Москва — Санкт-Петербург»', '+7 (4822) 797-797', '2026-03-10 09:56:03', '09:00:00', '21:00:00', 'images/center3.jpg', '<iframe src=\"https://yandex.ru/map-widget/v1/?um=constructor%3Ad033ce832c2a8bc7e933d830ee7c1235947327b97254ee5d3141e58d134a6930&amp;source=constructor\" frameborder=\"0\"></iframe>');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) DEFAULT '5',
  `text` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `name`, `rating`, `text`, `created_at`) VALUES
(1, NULL, 'Иван Петров', 5, 'Отличный сервис! Быстро записали, всё сделали качественно. Рекомендую.', '2026-04-13 10:05:18'),
(2, NULL, 'Алексей Смирнов', 4, 'Хороший сервисный центр, но немного задержали по времени. В целом доволен.', '2026-04-11 10:05:18'),
(3, NULL, 'Дмитрий Кузнецов', 5, 'Обслуживаю Geely уже второй год здесь. Всегда всё на уровне.', '2026-04-21 10:05:18'),
(4, NULL, 'Сергей Иванов', 5, 'Очень вежливый персонал и приятная атмосфера. Сделали ТО быстрее, чем ожидал.', '2026-02-21 10:05:18'),
(5, NULL, 'Андрей Волков', 4, 'Цены адекватные, всё объяснили и показали. Буду приезжать ещё.', '2026-01-21 10:05:18'),
(6, NULL, 'Михаил Соколов', 5, 'Лучший сервис в городе. Делал диагностику — нашли проблему сразу.', '2026-04-21 10:05:18'),
(7, NULL, 'Олег Васильев', 5, 'Удобная онлайн-запись и грамотные мастера. Всё понравилось!', '2026-03-11 10:05:18');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `recommended_mileage` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `recommended_mileage`, `price`, `created_at`) VALUES
(1, 'ТО 5 000 км', 'Проверка и замена масла, базовая диагностика', '5 000 км', '3500.00', '2026-03-10 10:09:33'),
(2, 'ТО 10 000 км', 'Замена масла, фильтров, проверка тормозов', '10 000 км', '5000.00', '2026-03-10 10:09:33'),
(3, 'ТО 15 000 км', 'Проверка подвески, масла, тормозов', '15 000 км', '5500.00', '2026-03-10 10:09:33'),
(4, 'ТО 20 000 км', 'Комплексная диагностика, замена масла и фильтров', '20 000 км', '9000.00', '2026-03-10 10:09:33'),
(5, 'Замена масла', 'Замена моторного масла и фильтров', 'по необходимости', '1500.00', '2026-03-10 10:09:33'),
(6, 'Диагностика двигателя', 'Полная диагностика силового агрегата', 'по необходимости', '2000.00', '2026-03-10 10:09:33'),
(7, 'Замена тормозных колодок', 'Замена передних и задних колодок', 'по состоянию', '2500.00', '2026-03-10 10:09:33'),
(8, 'Замена ремня ГРМ', 'Проверка и замена ремня ГРМ', '80 000–100 000 км', '7000.00', '2026-03-10 10:09:33'),
(9, 'Балансировка колес', 'Проверка и балансировка всех колес', 'каждые 10 000 км', '800.00', '2026-03-10 10:09:33'),
(10, 'Замена воздушного фильтра', 'Замена фильтра двигателя', 'каждые 15 000 км', '500.00', '2026-03-10 10:09:33');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('client','mechanic','admin') COLLATE utf8mb4_unicode_ci DEFAULT 'client',
  `center_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password_hash`, `created_at`, `role`, `center_id`) VALUES
(2, 'Илья', '89607092738', 'gruzdev_ilya16@mail.ru', '$2y$10$l0ntiy0eq7WXcU1WTWXvvOMO3ZMYiT9YCCbFvlkBdlMBVazlDbs0O', '2026-03-24 10:44:26', 'client', NULL),
(3, 'Иван Петров', '+79991234567', 'mechanic1@test.ru', '$2y$10$VKvY10rDV13E.GakmVsJi.Llux34HmymUpfU/yl9mnHOxgGNDSp2e', '2026-03-24 13:13:28', 'mechanic', 3),
(4, 'Администратор', '+79990000001', 'admin@test.ru', '$2y$10$VKvY10rDV13E.GakmVsJi.Llux34HmymUpfU/yl9mnHOxgGNDSp2e', '2026-03-24 13:21:06', 'admin', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `center_id` (`center_id`);

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
