-- Adminer 4.8.1 MySQL 8.0.38 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `age_limits` (`id`, `name`) VALUES
(1,	'18+'),
(2,	'6+'),
(3,	'16+'),
(4,	'12+'),
(5,	'0+');

INSERT INTO `cinema_shows` (`id`, `hall_id`, `film_id`, `date`, `start`, `end`) VALUES
(1,	1,	2,	'2024-07-07',	'10:00:00',	'12:00:00'),
(2,	1,	3,	'2024-07-07',	'12:00:00',	'15:00:00'),
(3,	1,	4,	'2024-07-07',	'15:00:00',	'18:00:00'),
(4,	1,	5,	'2024-07-07',	'18:00:00',	'21:00:00'),
(5,	3,	6,	'2024-07-07',	'10:00:00',	'12:00:00'),
(6,	3,	7,	'2024-07-07',	'12:00:00',	'14:00:00'),
(7,	3,	2,	'2024-07-07',	'15:00:00',	'18:00:00'),
(8,	3,	7,	'2024-07-07',	'19:00:00',	'21:00:00');

INSERT INTO `countries` (`id`, `name`) VALUES
(1,	'Россия'),
(2,	'Франция'),
(3,	'Великобритания'),
(4,	'Канада'),
(5,	'США'),
(6,	'Германия');

INSERT INTO `films` (`id`, `name`, `duration`, `age_limit`, `description`, `year_id`) VALUES
(2,	'Три богатыря. Ни дня без подвига',	61,	2,	'У трех богатырей что ни день, то подвиг по расписанию. То придется расследовать похищение княжеской короны, то спасать друзей из волшебного мира снов, то Конь Юлий с Алешей схлестнутся в эпической битве умов. Не бывает маленьких приключений, да и богатыри наши – немаленькие. Так что долго ли, коротко ли, а вас ждут три увлекательные истории разом.',	1),
(3,	'Самая большая луна',	99,	3,	'Эмеры — сверхлюди, наделенные необычными способностями. Они могут управлять человеческими эмоциями и не чувствуют боли. Однако они не способны по-настоящему любить. Однажды их мир оказывается под угрозой, и Денис, молодой эмер-полукровка, отправляется на поиски избранной, которая может всех спасти.',	3),
(4,	'Майор Гром: Игра',	162,	3,	'Майор полиции Игорь Гром известен всему Санкт-Петербургу пробивным характером и непримиримой позицией по отношению к преступникам всех мастей. Неимоверная сила, аналитический склад ума и неподкупность — все это делает майора Грома самым настоящим супергероем. Его жизнь идеальна: днем Гром ловит преступников вместе с напарником Димой Дубиным, а вечера проводит в компании журналистки Юлии Пчелкиной. Полную идиллию прерывает появление в городе таинственного злодея, называющего себя Призраком. Он предлагает Грому сыграть в опасную игру, ставка в которой — жизни обычных людей.',	1),
(5,	'Сто лет тому вперёд',	142,	2,	'Они живут в разных мирах. Коля Герасимов — в сегодняшней Москве, Алиса Селезнева — на сто лет позже. Коля – обычный парень, ему нет дела до будущего. Алису не отпускает прошлое: она должна найти маму, которую потеряла, когда была совсем ребенком. Встреча Алисы и Коли станет началом невероятных приключений, в которых нашим героям предстоит отвоевать у космических пиратов Вселенную, восстановить ход времени и обрести самое дорогое: любовь и дружбу.',	1),
(6,	'10 жизней',	86,	2,	'Все прекрасно знают, что у котов девять жизней. А еще говорят, что коты ленивые, капризные и довольно агрессивны к окружающим. И все-таки даже самые заносчивые из них просто душки по сравнению с пушистой бестией по имени Беккет! Но его будни скоро изменятся. Притом, целых десять раз! Коту предстоит побывать в шкуре совершенно разных животных, чтобы, наконец, начать ценить свою собственную жизнь.',	1),
(7,	'Город страха',	92,	1,	'Известного писателя Бена Монро приглашают в Берлин, чтобы помочь полиции с расследованием массового убийства членов тайного культа. Вскоре пропадает его дочь, которая познакомилась с молодым парнем. Чтобы разгадать тайну ее исчезновения, Бену придется понять, как связаны загадочные смерти с его произведениями.',	1);

INSERT INTO `films_contries` (`id`, `film_id`, `country_id`) VALUES
(1,	2,	1),
(2,	3,	1),
(3,	4,	1),
(5,	5,	1),
(6,	6,	3),
(7,	6,	4),
(8,	7,	5),
(9,	7,	6);

INSERT INTO `films_genres` (`id`, `film_id`, `genre_id`) VALUES
(1,	2,	1),
(2,	3,	2),
(3,	4,	3),
(4,	4,	4),
(5,	5,	3),
(6,	5,	4),
(7,	6,	5),
(8,	6,	6),
(9,	6,	7);

INSERT INTO `genres` (`id`, `name`) VALUES
(1,	'Анимационное Приключение'),
(2,	'Фэнтези'),
(3,	'Приключения'),
(4,	'Экшн'),
(5,	'Анимация'),
(6,	'Комедия'),
(7,	'Семейный'),
(8,	'Триллер'),
(9,	'Детектив');

INSERT INTO `halls` (`id`, `name`, `capacity`) VALUES
(1,	'Зал 1',	30),
(2,	'Зал 2',	40),
(3,	'Зал 3',	20),
(4,	'Зал 4',	35);

INSERT INTO `order_tickets` (`id`, `ticket_id`, `order_id`, `price`, `discount`) VALUES
(1,	1,	1,	500.00,	0.00),
(2,	2,	1,	500.00,	0.00),
(3,	3,	2,	500.00,	0.00),
(4,	4,	3,	450.00,	50.00),
(5,	5,	4,	500.00,	0.00),
(7,	11,	5,	800.00,	0.00);

INSERT INTO `orders` (`id`, `date_created`, `user_id`) VALUES
(1,	'2024-07-04 21:00:15',	1),
(2,	'2024-07-04 21:00:20',	2),
(3,	'2024-07-04 21:00:25',	3),
(4,	'2024-07-04 21:00:34',	1),
(5,	'2024-07-04 21:00:40',	1);

INSERT INTO `seats` (`id`, `hall_id`, `row`, `place`, `seat_type`) VALUES
(1,	1,	1,	1,	1),
(2,	1,	1,	2,	1),
(3,	1,	1,	3,	1),
(4,	1,	1,	4,	1),
(5,	1,	1,	5,	1),
(6,	1,	1,	6,	1),
(7,	1,	1,	7,	1),
(8,	1,	1,	8,	1),
(9,	1,	1,	9,	1),
(10,	1,	1,	10,	1),
(11,	1,	2,	1,	1),
(12,	1,	2,	2,	1),
(13,	1,	2,	3,	1),
(14,	1,	2,	4,	1),
(15,	1,	2,	5,	1),
(16,	3,	1,	1,	2),
(17,	3,	1,	2,	2),
(18,	3,	1,	3,	2),
(19,	3,	1,	4,	2),
(20,	3,	1,	5,	2);

INSERT INTO `seats_type` (`id`, `name`) VALUES
(1,	'кресло'),
(2,	'диван');

INSERT INTO `tickets` (`id`, `seat_id`, `price`, `cinema_show_id`) VALUES
(1,	1,	500.00,	1),
(2,	2,	500.00,	1),
(3,	3,	500.00,	1),
(4,	4,	500.00,	1),
(5,	5,	500.00,	1),
(6,	6,	500.00,	1),
(7,	7,	500.00,	1),
(8,	8,	500.00,	1),
(9,	9,	500.00,	1),
(10,	10,	500.00,	1),
(11,	16,	800.00,	5),
(12,	17,	800.00,	5),
(13,	18,	800.00,	5),
(14,	19,	800.00,	5),
(15,	20,	800.00,	5);

INSERT INTO `users` (`id`, `login`) VALUES
(1,	'ivan@mail.ru'),
(2,	'sidorov@mail.ru'),
(3,	'petrov@mail.ru');

INSERT INTO `years` (`id`, `name`) VALUES
(1,	2024),
(2,	2023),
(3,	2022);

-- 2024-07-04 21:21:47
