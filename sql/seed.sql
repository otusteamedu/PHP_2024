START TRANSACTION;
SET time_zone = "+00:00";

INSERT INTO `cinema_hall` (`id`, `name`) VALUES
(1, 'Комфорт'),
(2, 'Vip'),
(3, 'Kids');

INSERT INTO `director` (`director_id`, `name`, `surname`) VALUES
(1, 'Джеймс', 'Кэмерон'),
(2, 'Ридли', 'Скотт'),
(3, 'Крис', 'Коламбус');

INSERT INTO `genre` (`genre_id`, `name`) VALUES
(1, 'Триллер'),
(2, 'Боевик'),
(3, 'Ужасы'),
(4, 'Комедия');

INSERT INTO `movie` (`movie_id`, `name`, `description`, `rating`, `running_time`) 
VALUES
  (1, 'Терминатор', NULL, 5, 145),
  (2, 'Чужой', NULL, 5, 122),
  (3, 'Один дома', NULL, 4, 92);

INSERT INTO `session` (`id`, `movie_id`, `cinema_hall_id`, `date`, `price`)
VALUES
  (1, 1, 2, '2024-03-17 17:00:00', '600'),
  (2, 1, 2, '2024-03-17 20:00:00', '600'),
  (3, 2, 1, '2024-03-17 20:00:00', '500'),
  (4, 3, 3, '2024-03-17 12:00:00', '450');

INSERT INTO
  `seats` (`cinema_hall_id`, `row_number`, `seat_number`)
VALUES
  (1, 1, 1),
  (1, 1, 2),
  (1, 1, 3),
  (1, 1, 4),
  (1, 1, 5),
  (1, 2, 1),
  (1, 2, 2),
  (1, 2, 3),
  (1, 2, 4),
  (1, 2, 5),
  (1, 3, 1),
  (1, 3, 2),
  (1, 3, 3),
  (1, 3, 4),
  (1, 3, 5),
  (2, 1, 1),
  (2, 1, 2),
  (2, 1, 3),
  (2, 1, 4),
  (2, 1, 5),
  (2, 2, 1),
  (2, 2, 2),
  (2, 2, 3),
  (2, 2, 4),
  (2, 2, 5),
  (2, 3, 1),
  (2, 3, 2),
  (2, 3, 3),
  (2, 3, 4),
  (2, 3, 5),
  (3, 1, 1),
  (3, 1, 2),
  (3, 1, 3),
  (3, 1, 4),
  (3, 1, 5),
  (3, 2, 1),
  (3, 2, 2),
  (3, 2, 3),
  (3, 2, 4),
  (3, 2, 5),
  (3, 3, 1),
  (3, 3, 2),
  (3, 3, 3),
  (3, 3, 4),
  (3, 3, 5);

INSERT INTO `movie_director` (`movie_id`, `director_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO `movie_genre` (`movie_id`, `genre_id`) 
VALUES
(1, 2),
(2, 3),
(3, 4);

INSERT INTO `visitor` (`email`) 
VALUES
('hahsfhlk@ya.ru'),
('john@gmail.com'),
('borisbritva@mail.ru');

INSERT INTO
  ticket (
    session_id,
    seat_id,
    selling_price,
    purchase_time,
    visitor_id
  )
VALUES
  (1, 1, '500', '2024-03-03 10:00:00', 1),
  (3, 2, '480', '2024-03-02 11:00:00', 2),
  (1, 3, '600', '2024-03-03 11:00:00', null),
  (3, 4, '300', '2024-03-04 11:00:00', 2),
  (1, 5, '320', '2024-03-04 11:00:00', 1),
  (2, 6, '340','2024-03-04 14:00:00', 2),
  (4, 7, '340','2024-03-05 14:00:00', null),
  (2, 8, '520','2024-03-06 14:00:00', 3),
  (3, 9, '760','2024-03-07 14:00:00', 2),
  (3, 10, '800', '2024-03-10 14:00:00', 2);

COMMIT;