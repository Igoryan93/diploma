-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 08 2020 г., 10:00
-- Версия сервера: 5.6.47
-- Версия PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `registration2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `role`) VALUES
(1, 'Standart user', ''),
(2, 'Admin', '{\"admin\":1}'),
(3, 'Moderator', '{\"moderator\":1}');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `text`, `group_id`, `date`) VALUES
(1, 'shery@gmail.com', 'Shery Birkin', '$2y$10$BD0dE2GELmbx4/jkGVd6MuOms5sS4DmhAEz762LAz4BGmqgP9EDue', 'Тест изменения текстового поля с роли админа произвольного пользователя!!!', 1, '06/12/2020'),
(2, 'ada_wong@gmail.com', 'Ada Wong', '$2y$10$0uVMNQ63XaCx9pBI5.UPQuGidWZ7LIWVy138u8xJIpyulCMFm4hwi', 'Проверка на сходство паролей! ', 2, '06/12/2020'),
(38, 'leon@gmail.com', 'Leon Kennedy', '$2y$10$qMXOErg7QmPHtyMJMokAfOWm0B3cmDmVSJ1xDGeEBY/ek7M2PTqx6', 'Привет! Я новый пользователь вашего проекта, хочу перейти на уровень 3!  ', 1, '06/12/2020'),
(43, 'ivanov@gmail.com', 'Ivanov Ivan', '$2y$10$9hl5Ru4r7AQ3yVZ1ya2Cj.AS8mST22yaRATAr9/.T3NjffsltFz8.', 'Статуст изменился успешно!', 1, '07/12/2020'),
(44, 'marvin@gmail.com', 'Marvin Branagh', '$2y$10$yfvXDF4uo5byxD1CP5ro7uXOj/IyB8UFeYKdugLOtpqpH76VTfQqm', 'Проверка Куки пользователя!', 1, '08/12/2020');

-- --------------------------------------------------------

--
-- Структура таблицы `users_cookie`
--

CREATE TABLE `users_cookie` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users_cookie`
--
ALTER TABLE `users_cookie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `users_cookie`
--
ALTER TABLE `users_cookie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
