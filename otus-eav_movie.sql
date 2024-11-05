CREATE DATABASE otus_eav ENCODING = 'UTF8';

-- подключаемся к otus_eav

CREATE TABLE movie (
	id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL
);

CREATE INDEX id_movie_idx ON movie (id);

INSERT INTO movie(title)
VALUES 
    ('Люди Х');

CREATE TABLE attribute_type (
	id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL
);      

CREATE INDEX id_attribute_type_idx ON attribute_type (id);

INSERT INTO attribute_type(title)
VALUES 
    ('value_int'),
    ('value_text'),
	('value_bool'),
    ('value_date'),
	('value_decimal'),
    ('value_task_date');

CREATE TABLE attribute_name (
	id SERIAL PRIMARY KEY,
    attribute_type_id INTEGER REFERENCES attribute_type,
	title VARCHAR(50) NOT NULL
); 

CREATE INDEX id_attribute_name_idx ON attribute_name (id);

INSERT INTO attribute_name(attribute_type_id, title)
VALUES 
    (1, 'мировые сборы'),
    (2, 'описание'),
    (3, 'оскар'),
    (4, 'начало проката'),
    (4, 'конец проката'),
    (5, 'средняя цена билета в РФ'),
    (6, 'запуск рекламы'),
    (6, 'старт продажи билетов');

CREATE TABLE attribute_value (
	id SERIAL PRIMARY KEY,
    movie_id INTEGER REFERENCES movie,
    attribute_name_id INTEGER REFERENCES attribute_name,
    value_int INTEGER,
    value_text TEXT,
    value_decimal DECIMAL,
    value_bool BOOLEAN,
    value_date DATE,
    value_task_date DATE
);  

CREATE INDEX id_attribute_value_idx ON attribute_value (id);

INSERT INTO attribute_value(
    movie_id, attribute_name_id, 
    value_int, value_text, value_decimal, value_bool, value_date, value_task_date
    )
VALUES 
    (1, 1, 1000000000, NULL, NULL, NULL, NULL, NULL),
    (1, 2, NULL, 'bla bla bla', NULL, NULL, NULL, NULL),
    (1, 3, NULL, NULL, NULL, TRUE, NULL, NULL),
    (1, 4, NULL, NULL, NULL, NULL, '01.12.2024', NULL),
    (1, 5, NULL, NULL, NULL, NULL, '01.02.2025', NULL),
    (1, 6, NULL, NULL, 300.50,  NULL, NULL, NULL),
    (1, 7, NULL, NULL, NULL, NULL, NULL, '27.09.2024'),
    (1, 8, NULL, NULL, NULL, NULL, NULL, '17.10.2024');

-- запросы

CREATE VIEW marketing_report AS
SELECT
m.title AS "Название фильма",
an.title 
    || ' (' || 
        CASE 
            WHEN at.title = 'value_date' THEN 'дата'
            WHEN at.title = 'value_int' THEN 'число'
            WHEN at.title = 'value_text' THEN 'текст'
            WHEN at.title = 'value_decimal' THEN 'руб'
            WHEN at.title = 'value_date' THEN 'дата'
            WHEN at.title = 'value_bool' THEN 'да/нет'
            WHEN at.title = 'value_task_date' THEN 'дата задачи'
        END
    || ')' AS "Параметр", 
COALESCE (av.value_text, av.value_date::TEXT, 
    (
        CASE
            WHEN av.value_bool = TRUE THEN 'да'
            WHEN av.value_bool = FALSE THEN 'нет'
        END
    ),
    av.value_bool::TEXT, av.value_int::TEXT, av.value_decimal::TEXT, av.value_task_date::TEXT) AS "Значение"
FROM movie m
JOIN attribute_value av ON m.id = av.movie_id
JOIN attribute_name an ON an.id = av.attribute_name_id
JOIN attribute_type at ON at.id = an.attribute_type_id; 

SELECT * FROM marketing_report;

CREATE VIEW task_schedule AS
SELECT
m.title AS "Название фильма",
an.title AS "Задача", 
av.value_task_date AS "Дата"
FROM movie m
JOIN attribute_value av ON m.id = av.movie_id
JOIN attribute_name an ON an.id = av.attribute_name_id
JOIN attribute_type at ON at.id = an.attribute_type_id AND at.title = 'value_task_date'
	AND (av.value_task_date = CURRENT_DATE OR av.value_task_date = CURRENT_DATE + INTERVAL '20 day');

SELECT * FROM task_schedule;