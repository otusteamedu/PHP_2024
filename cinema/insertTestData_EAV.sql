insert into attribute_types(type) values
  ('boolean'),
  ('integer'),
  ('float'),
  ('date'),
  ('varchar'),
  ('text');

insert into attributes(name, typeId) values
  ('рецензия критика', 6),
  ('отзыв неизвестной киноакадемии', 6),
  ('оскар', 1),
  ('ника', 1),
  ('мировая премьера', 4),
  ('премьера в РФ', 4),
  ('дата начала продажи билетов', 4),
  ('когда запускать рекламу на ТВ', 4);

insert into movie_attributes(movieId, attributeId, text) values
  (1, 1, 'Пересматривая этот шедевр анимации, понимаешь, насколько он актуален и по сей день...'),
  (2, 2, 'Это продолжение истории о зеленом великане, который уже успел жениться на принцессе Фионе...');

insert into movie_attributes(movieId, attributeId, boolean) values
  (1, 3, true),
  (2, 4, false);

insert into movie_attributes(movieId, attributeId, date) values
  (1, 5, '2001-04-22'),
  (2, 6, '2004-08-19'),
  (1, 7, '2024-08-05'),
  (1, 8, '2024-08-25'),
  (2, 8, '2024-08-25'),
  (2, 7, '2024-08-05');
