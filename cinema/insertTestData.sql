insert into halls(name, basePrice) values
  ('Зал 1', 1200),
  ('Зал 2', 1000);

insert into rows(hallId, row) values
  (1, 1),
  (2, 1);

insert into seats(rowId, seat, extraPrice) values
  (1, 1, 0),
  (1, 2, 100),
  (1, 3, 0),
  (2, 1, 0),
  (2, 2, 100),
  (2, 3, 0);

insert into movies(name, duration, category, origin, releaseDate) values
  ('Шрек', 5400, 'мультфильмы', 'США', '2001-04-22'),
  ('Шрек 2', 5580, 'мультфильмы', 'США', '2004-05-15');

insert into shows(movieId, hallId, startAt, extraPrice, maxDiscount) values
  (1, 1, '2024-07-24 19:00:00', 0, 100),
  (2, 2, '2024-07-24 19:00:00', 200, 0);

insert into tickets(showId, seatId, soldPrice, soldAt) values
  (1, 2, 1234, '2024-07-24 05:02:01'),
  (1, 3, 1222, '2024-07-24 05:04:01'),
  (2, 4, 1111, '2024-07-24 05:06:01'),
  (2, 5, 1357, '2024-07-24 05:07:01');