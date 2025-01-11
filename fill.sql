--movies

INSERT INTO movies (title) VALUES
('Inception'),
('The Matrix'),
('Interstellar');

--attribute_types

INSERT INTO attribute_types (type_name) VALUES
('Рецензии'),
('Премия'),
('Важные даты'),
('Служебные даты');

--attributes

INSERT INTO attributes (attribute_name, type_id) VALUES
('Рецензии критиков', 1),
('Отзыв неизвестной киноакадемии', 1),
('Оскар', 2),
('Ника', 2),
('Мировая премьера', 3),
('Премьера в РФ', 3),
('Дата начала продажи билетов', 4),
('Когда запускать рекламу на ТВ', 4);

--attribute_values

INSERT INTO attribute_values (movie_id, attribute_id, value_text) VALUES
(1, 1, 'Отличный фильм с захватывающим сюжетом'),
(2, 1, 'Культовый фильм, изменивший жанр научной фантастики');

INSERT INTO attribute_values (movie_id, attribute_id, value_boolean) VALUES
(1, 2, TRUE),
(2, 2, FALSE);

INSERT INTO attribute_values (movie_id, attribute_id, value_date) VALUES
(1, 3, '2010-07-16'),
(2, 3, '1999-03-31'),
(3, 3, '2014-11-07');

INSERT INTO attribute_values (movie_id, attribute_id, value_date) VALUES
(1, 4, '2010-06-01'),
(2, 4, '1999-02-01'),
(3, 4, '2014-10-01');

INSERT INTO attribute_values (movie_id, attribute_id, value_integer) VALUES
(1, 7, 100),
(2, 7, 120);

INSERT INTO attribute_values (movie_id, attribute_id, value_float) VALUES
(1, 8, 9.5),
(2, 8, 8.7);
