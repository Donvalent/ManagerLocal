-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 15 2020 г., 20:59
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `managerdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `days_info`
--

CREATE TABLE `days_info` (
  `users_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `info` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `days_info`
--

INSERT INTO `days_info` (`users_id`, `date`, `info`) VALUES
(2, '2019-06-07', '{\"Time to work\": \"2\", \"Steam Client Bootstrapper\": 5, \"Microsoft Visual Studio 2017\": 5}'),
(1, '2019-06-08', '{\"Time to work\": \"2\", \"Microsoft Visual Studio 2017\": 3}');

-- --------------------------------------------------------

--
-- Структура таблицы `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `departments`
--

INSERT INTO `departments` (`id`, `title`) VALUES
(1, 'Отдел разработки'),
(2, 'Отдел продаж'),
(3, 'Отдел аналитики');

-- --------------------------------------------------------

--
-- Структура таблицы `department_staff`
--

CREATE TABLE `department_staff` (
  `workers_id` int(11) NOT NULL,
  `departments_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `department_staff`
--

INSERT INTO `department_staff` (`workers_id`, `departments_id`) VALUES
(2, 2),
(3, 1),
(4, 2),
(2, 3),
(4, 3),
(3, 4),
(4, 4),
(5, 1),
(1, 1),
(1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `login`
--

INSERT INTO `login` (`id`, `login`, `password`, `admin`) VALUES
(1, 'Donvalent', 'Valentin', 1),
(2, 'Leonid1999', 'Leon', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `salary` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`id`, `title`, `salary`) VALUES
(1, 'team leader', 35000),
(2, 'team leader', 70000),
(3, 'junior backend developer', 50000),
(4, 'middle backend developer', 50000),
(5, 'Junior analyst', 50000);

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(300) NOT NULL,
  `worker` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `date` date NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `worker`, `status`, `date`, `deadline`) VALUES
(1, 'Поправить верстку сайта', 'Карты должны быть в середине, заполнить пустое пространство, найти красивые иконки.', 1, -1, '2019-06-05', '2019-06-06'),
(2, 'Доделать функционал оплаты заказа', 'Не работает оплата товара, необходимо добавить форму и наладить работу с api банка для оплаты.', 5, 0, '2019-06-05', '2019-06-20'),
(3, 'Реализовать модуль редактирования данных', 'Необходимо реализовать модуль редактирования конкретных данных', 1, 0, '2019-06-10', '2019-06-20');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `fullName`, `gender`, `phone`, `email`, `position`) VALUES
(1, 'Пащенко Валентин Андреевич', 'Мужчина', '8 (999) 999-99-99', 'MyEmail@email.com', 1),
(2, 'Букин Леонид Викторович', 'Мужчина', '+799999429249', 'EMSAIJDLA@dkasjdksa.da', 2),
(3, 'Сморчкова Злата Игоревна', 'Женщина', '8 (925) 856-46-26', 'Smorchkova@email.com', 3),
(4, 'Осипова Пульхерия Даниловна', 'Женщина', '8 (909) 780-21-37', 'dasdsa@dasdsa.lf', 4),
(5, 'Тарантьев Леонид Сергеевич', 'Мужчина', '512521421421', 'Lenya@mail.ru', 5);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `days_info`
--
ALTER TABLE `days_info`
  ADD KEY `users_id` (`users_id`);

--
-- Индексы таблицы `login`
--
ALTER TABLE `login`
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `worker` (`worker`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `position` (`position`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `days_info`
--
ALTER TABLE `days_info`
  ADD CONSTRAINT `days_info_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`worker`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
