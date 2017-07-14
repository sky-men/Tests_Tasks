-- Версия сервера: 5.7.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `review` text NOT NULL,
  `image` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `review`, `image`, `date`) VALUES
(23, 'Nick', 'qwerty@mail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hendrerit aliquam arcu. Nunc non pulvinar massa. Donec ac ante vel est ultricies venenatis non id dolor. Sed fermentum magna vel malesuada pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec euismod elit non leo luctus dignissim. Nulla facilisi. Cras lobortis elit in posuere mattis. Vivamus pellentesque orci nec tempor ullamcorper. Nulla luctus sit amet purus sit amet suscipit. Phasellus a porta lacus. Cras laoreet ligula nec urna vulputate, at euismod sapien eleifend. Proin ornare pellentesque est nec rhoncus. Aliquam molestie mattis quam, vitae ultrices lorem cursus eget. Morbi porta aliquam lacus sed vulputate. Aliquam in lorem luctus, euismod mi eget, maximus ligula. Etiam eget scelerisque orci. Donec pharetra condimentum lacus eget luctus. Nullam sed sapien efficitur lacus mollis porta. Aliquam eget leo metus. Ut cursus ultricies tristique. Aliquam pretium quam et enim ultricies scelerisque.', 'img3EC7.jpg', '2016-07-19 17:50:40'),
(24, 'Pete', 'tmp@mail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hendrerit aliquam arcu. Nunc non pulvinar massa. Donec ac ante vel est ultricies venenatis non id dolor. Sed fermentum magna vel malesuada pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec euismod elit non leo luctus dignissim. Nulla facilisi.', NULL, '2016-07-19 18:37:02'),
(25, 'Sam', 'dot@mut.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hendrerit aliquam arcu. Nunc non pulvinar massa. Donec ac ante vel est ultricies venenatis non id dolor. Sed fermentum magna vel malesuada pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec euismod elit non leo luctus dignissim. Nulla facilisi.', 'imgE78E.jpg', '2016-07-19 18:38:53'),
(26, 'Taylor', 'cat@mail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In hendrerit aliquam arcu. Nunc non pulvinar massa. Donec ac ante vel est ultricies venenatis non id dolor. Sed fermentum magna vel malesuada pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec euismod elit non leo luctus dignissim. Nulla facilisi.', 'img6DA3.jpg', '2016-07-23 21:33:32');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews_status`
--

CREATE TABLE `reviews_status` (
  `review_id` int(11) UNSIGNED NOT NULL,
  `on_moderation` tinyint(1) NOT NULL DEFAULT '1',
  `changed` tinyint(1) NOT NULL DEFAULT '0',
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `rejected` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `reviews_status`
--

INSERT INTO `reviews_status` (`review_id`, `on_moderation`, `changed`, `accepted`, `rejected`) VALUES
(23, 0, 0, 0, 1),
(24, 1, 0, 0, 0),
(25, 0, 1, 1, 0),
(26, 0, 1, 1, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `date` (`date`),
  ADD KEY `email` (`email`);

--
-- Индексы таблицы `reviews_status`
--
ALTER TABLE `reviews_status`
  ADD UNIQUE KEY `review_id` (`review_id`),
  ADD UNIQUE KEY `id_accepted` (`review_id`,`accepted`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `reviews_status`
--
ALTER TABLE `reviews_status`
  ADD CONSTRAINT `FK_reviews_id` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
