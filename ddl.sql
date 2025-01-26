CREATE TABLE movie
(
    id           SERIAL PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    release_year INT,
    duration     INT
);

CREATE TABLE attribute_type
(
    id   SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(10)  NOT NULL,
    code VARCHAR(255) NOT NULL
);

CREATE TABLE attribute
(
    id                SERIAL PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    code              VARCHAR(255) NOT NULL,
    attribute_type_id INT REFERENCES attribute_type (id) ON DELETE CASCADE
);

CREATE TABLE attribute_value
(
    id            SERIAL PRIMARY KEY,
    value_text    TEXT,
    value_float   REAL,
    value_boolean BOOLEAN DEFAULT false NOT NULL,
    value_date    DATE,
    value_integer INTEGER,
    attribute_id  INT REFERENCES attribute (id) ON DELETE CASCADE,
    movie_id      INT REFERENCES movie (id) ON DELETE CASCADE
);

INSERT INTO movie (title, release_year, duration)
VALUES ('Фильм 1', 2020, 120),
       ('Фильм 2', 2021, 110);

INSERT INTO attribute_type (name, type, code)
VALUES ('Рецензии', 'text', 'reviews'),
       ('Премии', 'boolean', 'awards'),
       ('Важные даты', 'date', 'important_dates'),
       ('Служебные даты', 'date', 'service_dates');

INSERT INTO attribute (name, code, attribute_type_id)
VALUES ('Рецензия критиков', 'critics_review', (SELECT id FROM attribute_type WHERE code = 'reviews')),
       ('Отзыв неизвестной киноакадемии', 'unknown_academy_review',
        (SELECT id FROM attribute_type WHERE code = 'reviews')),
       ('Оскар', 'oscar', (SELECT id FROM attribute_type WHERE code = 'awards')),
       ('Ника', 'nika', (SELECT id FROM attribute_type WHERE code = 'awards')),
       ('Мировая премьера', 'world_premiere', (SELECT id FROM attribute_type WHERE code = 'important_dates')),
       ('Премьера в РФ', 'premiere_in_russia', (SELECT id FROM attribute_type WHERE code = 'important_dates')),
       ('Дата начала продажи билетов', 'ticket_sales_start_date',
        (SELECT id FROM attribute_type WHERE code = 'service_dates')),
       ('Когда запускать рекламу на ТВ', 'when_to_launch_tv_ads',
        (SELECT id FROM attribute_type WHERE code = 'service_dates'));

INSERT INTO attribute_value (movie_id, attribute_id, value_text, value_boolean, value_date)
VALUES (1, (SELECT id FROM attribute WHERE code = 'critics_review'), 'Отличный фильм!', false, null),
       (1, (SELECT id FROM attribute WHERE code = 'oscar'), null, true, null),
       (1, (SELECT id FROM attribute WHERE code = 'world_premiere'), null, false, '2024-12-01'),
       (2, (SELECT id FROM attribute WHERE code = 'premiere_in_russia'), null, false, '2025-01-10'),
       (2, (SELECT id FROM attribute WHERE code = 'ticket_sales_start_date'), null, false, '2025-01-25'),
       (2, (SELECT id FROM attribute WHERE code = 'when_to_launch_tv_ads'), null, false, '2025-02-15');
