-- Заполнение таблицы типов атрибутов
INSERT INTO attribute_types (type_name) VALUES ('Text'), ('Date'), ('Boolean'), ('Float'), ('Int');


-- Заполнение таблицы атрибутов
INSERT INTO attributes (attribute_name, type_id) 
VALUES ('Рецензия', 1), ('Премия Оскар', 3), ('Дата мировой премьеры', 2), ('Рейтинги', 4), ('Количество зрителей', 5);


-- Пример вставки данных в таблицу значений
INSERT INTO films (title, release_year) VALUES ('Inception', 2010);

INSERT INTO attribute_values (film_id, attribute_id, value_text)
VALUES (1, 1, 'Рецензия критиков: потрясающий фильм!');

INSERT INTO attribute_values (film_id, attribute_id, value_boolean)
VALUES (1, 2, TRUE);

INSERT INTO attribute_values (film_id, attribute_id, value_date)
VALUES (1, 3, '2010-07-16');

INSERT INTO attribute_values (film_id, attribute_id, value_float)
VALUES (1, 4, 12.34), (1, 4, 45.67), (1, 4, 89.12);

INSERT INTO attribute_values (film_id, attribute_id, value_int)
VALUES (1, 5, 10000);