-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 31 2025 г., 11:41
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `smartdragon`
--

-- --------------------------------------------------------

--
-- Структура таблицы `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `topics`
--

INSERT INTO `topics` (`id`, `title`, `description`, `content`, `author_id`, `created_at`, `image_path`) VALUES
(16, 'Гайд по террарии', 'Здесь будет гайд по классу призывателя', 'Основные моменты игрового процесса призывателя в Terraria:\r\nНачальный этап\r\nВ начале игры сложно, потому что выбор посохов и экипировки для призыва ограничен. Рекомендуется искать и использовать \"Посох зяблика\" (получается из деревянных сундуков гигантских деревьев) или \"Посох слизня\", который падает со слизней. Также можно создать \"Цветок Абигейл\" из надгробий (кладбища), когда появится. Эти предметы позволяют призывать первых прислужников и постепенно развиваться.\r\n\r\nОружие и прислужники\r\nПризыватель использует посохи, которые вызывают миньонов (последователей). Они автоматически следуют за игроком и атакуют врагов в радиусе действия, при этом не могут быть убиты, и не теряют своих баффов. Игрок начинает с возможностью призвать одного прислужника, но с помощью специализированных аксессуаров и зелий можно увеличивать максимальное число до 11.\r\n\r\nАксессуары для усиления призывателя:\r\n\r\nОжерелье пигмеев — добавляет одного дополнительного прислужника.\r\n\r\nЖук Геркулес — увеличивает урон и отбрасывание прислужников.\r\n\r\nСвиток некромантии и Папирусный скарабей — увеличивают урон и максимальное число прислужников.\r\n\r\nЭмблема призывателя — увеличивает урон призванных.\r\n\r\nОгненная рукавица — дает автоатаку хлысту и усиливает урон.\r\n\r\nЗелья и баффы\r\nЗелье призыва и Колдовской стол увеличивают максимальное количество прислужников на определённое время, что полезно для сильных боёв и боссов.\r\n\r\nБоевая тактика\r\nВаша задача — следить за прислужниками, их расстановкой и боевой эффективностью, а также избегать прямых повреждений, так как персонаж призывателя чаще всего достаточно уязвим. Используйте прислужников для нанесения урона и отвлечения врагов, а сами старайтесь держаться в безопасности и контролировать ситуацию.\r\n\r\nСборка и развитие\r\nНачинающий призыватель должен сосредоточиться на сборе посохов и экипировки для призыва.\r\n\r\nВ дальнейшем улучшайте аксессуары и зелья, прокачивайте максимальное число прислужников.\r\n\r\nСледите за обновлениями версии Terraria, так как с выходом 1.4 и выше призыватель получил много новых возможностей и усилений.', 11, '2025-07-31 08:53:57', 'uploads/topics/1753952037_0bf7c5e73f_maxresdefault1.jpg'),
(17, 'Гайд по ForHonor', 'Игра за Нобуси', '🗡️ Кто такой Нобуси?\r\nКласс: Атакующий (Light)\r\nОружие: Катана\r\nФишка: Скорость, мобильность, дамаг в ближнем бою.\r\nДля кого: Для тех, кто любит нож в спину, дробить щит и убивать за 2 секунды.\r\n⚔️ Основные фишки:\r\n🔹 Уникальная способность — \"Иайдо\" (Iaijutsu)\r\nНажимаешь RB + R2 (зависит от платформы) — выхватываешь меч и сразу рубишь.\r\nЕсли попал — оглушение + урон.\r\nИспользуй:\r\nПосле уклонения.\r\nПо слепому углу.\r\nКогда враг встаёт после смерти.\r\nПротив тяжёлых — их уязвимость после блока = твой обед.\r\n💡 Pro tip: Иайдо — не для фронтальных атак. Это сюрприз, а не агрессия. \r\n\r\n🎯 Стиль игры:\r\nНе стой на месте. Беги, прыгай, уворачивайся.\r\nДроби щит. Удары снизу (↓ + атака) — твой хлеб. Особенно против рыцарей.\r\nРежь по слепым зонам. У всех тяжелых — задняя атака = почти смерть.\r\nКонтролируй дистанцию. Не давай врагу дышать в затылок.\r\n🔁 Комбо (базовые):\r\n↑ + атака → ↑ + атака → ↓ + атака — быстрый дамаг.\r\n↓ + атака → RB + R2 (Иайдо) — дробим щит + добиваем.\r\nУклон → Иайдо — смертельный сценарий против всех.\r\n🛡️ Против кого силен?\r\n✅ Всадники / Пикейщики: Слишком медленные. Уклон → руби.\r\n✅ Тяжёлые (Варвары, Паладины): Щит дробится, задняя атака = free kill.\r\n❌ Другие лёгкие (Ашигару, Варвары-бешеные): Тут уже гонка. Кто быстрее, тот и жив.\r\n🧠 Тактика от геймера:\r\nСтарт: Не лезь в бой первым. Пусть другие дерутся.\r\nФланг: Обходи сбоку/сзади. Лучший друг Нобуси — неожиданность.\r\nФарм: Убивай раненых. Не геройствуй.\r\nРежим \"хищник\": Видишь одинокого — сразу Иайдо → добить.\r\n🧰 Снаряжение (рекомендуемое):\r\nОружие: Баланс + скорость.\r\nДоспех: Лёгкий (макс скорость) или средний (чтобы не умирал сразу).\r\nПерки:\r\nУвеличение урона по щиту.\r\nУскорение Иайдо.\r\nСнижение урона от тяжёлых.\r\n🚫 Чего НЕ делать:\r\n❌ Не вступай в дуэль 1х1 с тяжёлым лоб в лоб.\r\n❌ Не стой в центре — тебя снесут.\r\n❌ Не трать Иайдо впустую — перезарядка долгая.\r\n💬 Финальный совет:\r\n\"Нобуси — это нож в темноте, а не меч в бою.\"\r\nБудь тенью. Убивай. Исчезай. \r\n\r\n🎮 GG. Убивай с честью, но убивай первым.\r\n#ForHonor #Нобуси #SamuraiProblems', 12, '2025-07-31 09:00:05', 'uploads/topics/1753952405_aa25dad603_maxresdefault2.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('administrator','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `nickname`, `fullname`, `email`, `password_hash`, `role`, `created_at`) VALUES
(11, 'Admin', '', 'Admin@mail.ru', '$2y$10$3Uo8ecd.3pgsjWQPow5DVOzh5BmIGWzwHrAfNZD.8GbegBtLsmsI.', 'administrator', '2025-07-31 01:22:14'),
(12, 'User', 'Artem', 'User@mail.ru', '$2y$10$ng95NHm3X0ATexyv.Cok9e92KA8s3IYIwwwhVkb/4VgAWn//j8ovy', 'user', '2025-07-31 01:23:40'),
(13, 'None', '', 'None@mail.ru', '$2y$10$Xz5TuE9BJ/xvem6am966/uNlz6M7e2L.B/8E050u9hFRwHO.0xpFy', 'user', '2025-07-31 01:45:52');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
