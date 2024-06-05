# HW9

## Цель

- Потренироваться в написании сложных SQL-запросов поверх схемы для проверки правильности структуры.
- Усилить схему гибким хранением значений различного типа без нарушения нормализации.

### В базе данных используются следующие таблицы:

1. `movies` - таблица с фильмами.
2. `attribute_types` - таблица с типами атрибутов.
3. `attributes` - таблица с атрибутами фильмов.
4. `values` - таблица со значениями атрибутов.

### Создание таблиц

```sql
-- Таблица фильмов
CREATE TABLE movies
(
    id    SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL
);

-- Таблица типов атрибутов
CREATE TABLE attribute_types
(
    id        SERIAL PRIMARY KEY,
    name      VARCHAR(255) NOT NULL,
    data_type VARCHAR(50)  NOT NULL
);

-- Таблица атрибутов
CREATE TABLE attributes
(
    id                SERIAL PRIMARY KEY,
    movie_id          INT          NOT NULL,
    attribute_type_id INT          NOT NULL,
    name              VARCHAR(255) NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies (id),
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);

-- Таблица значений
CREATE TABLE values
(
    id            SERIAL PRIMARY KEY,
    attribute_id  INT NOT NULL,
    text_value    TEXT,
    boolean_value BOOLEAN,
    date_value    DATE,
    float_value   FLOAT,
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);

-- Индексы
CREATE INDEX idx_movie_id ON attributes (movie_id);
CREATE INDEX idx_attribute_type_id ON attributes (attribute_type_id);
CREATE INDEX idx_attribute_id ON values (attribute_id);
```

### Вставка данных

```sql
-- Типы атрибутов
INSERT INTO attribute_types (name, data_type)
VALUES ('рецензии', 'text'),
       ('премия', 'boolean'),
       ('важные даты', 'date'),
       ('служебные даты', 'date');

-- Фильмы
INSERT INTO movies (title)
VALUES ('The Shawshank Redemption'),
       ('The Godfather'),
       ('Pulp Fiction');
```

### Атрибуты и значения

#### Атрибуты

```sql
INSERT INTO attributes (movie_id, attribute_type_id, name)
VALUES

-- The Shawshank Redemption
(1, (SELECT id FROM attribute_types WHERE name = 'рецензии'), 'Рецензия критиков'),
(1, (SELECT id FROM attribute_types WHERE name = 'премия'), 'Оскар'),
(1, (SELECT id FROM attribute_types WHERE name = 'важные даты'), 'Мировая премьера'),
(1, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Дата начала продажи билетов'),
(1, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Когда запускать рекламу на ТВ'),

-- The Godfather
(2, (SELECT id FROM attribute_types WHERE name = 'рецензии'), 'Рецензия критиков'),
(2, (SELECT id FROM attribute_types WHERE name = 'премия'), 'Оскар'),
(2, (SELECT id FROM attribute_types WHERE name = 'важные даты'), 'Мировая премьера'),
(2, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Дата начала продажи билетов'),
(2, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Когда запускать рекламу на ТВ'),

-- Pulp Fiction
(3, (SELECT id FROM attribute_types WHERE name = 'рецензии'), 'Рецензия критиков'),
(3, (SELECT id FROM attribute_types WHERE name = 'премия'), 'Оскар'),
(3, (SELECT id FROM attribute_types WHERE name = 'важные даты'), 'Мировая премьера'),
(3, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Дата начала продажи билетов'),
(3, (SELECT id FROM attribute_types WHERE name = 'служебные даты'), 'Когда запускать рекламу на ТВ');
```

#### Значения

```sql
-- The Shawshank Redemption
INSERT INTO values (attribute_id, text_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 1 AND name = 'Рецензия критиков'),
        'An inspiring story of hope and friendship.');
INSERT INTO values (attribute_id, boolean_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 1 AND name = 'Оскар'), FALSE);
INSERT INTO values (attribute_id, date_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 1 AND name = 'Мировая премьера'), '1994-09-10'),
       ((SELECT id FROM attributes WHERE movie_id = 1 AND name = 'Дата начала продажи билетов'), '1994-08-01'),
       ((SELECT id FROM attributes WHERE movie_id = 1 AND name = 'Когда запускать рекламу на ТВ'), '1994-07-01');

-- The Godfather
INSERT INTO values (attribute_id, text_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 2 AND name = 'Рецензия критиков'), 'A masterpiece of crime drama.');
INSERT INTO values (attribute_id, boolean_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 2 AND name = 'Оскар'), TRUE);
INSERT INTO values (attribute_id, date_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 2 AND name = 'Мировая премьера'), '1972-03-15'),
       ((SELECT id FROM attributes WHERE movie_id = 2 AND name = 'Дата начала продажи билетов'), '1972-02-01'),
       ((SELECT id FROM attributes WHERE movie_id = 2 AND name = 'Когда запускать рекламу на ТВ'), '1972-01-01');

-- Pulp Fiction
INSERT INTO values (attribute_id, text_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 3 AND name = 'Рецензия критиков'),
        'A wildly original and entertaining film.');
INSERT INTO values (attribute_id, boolean_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 3 AND name = 'Оскар'), TRUE);
INSERT INTO values (attribute_id, date_value)
VALUES ((SELECT id FROM attributes WHERE movie_id = 3 AND name = 'Мировая премьера'), '1994-05-21'),
       ((SELECT id FROM attributes WHERE movie_id = 3 AND name = 'Дата начала продажи билетов'), '1994-04-01'),
       ((SELECT id FROM attributes WHERE movie_id = 3 AND name = 'Когда запускать рекламу на ТВ'), '1994-03-01');
```

### Создание представлений

#### Представление для служебных данных

```sql
DROP VIEW IF EXISTS service_tasks_view;

CREATE VIEW service_tasks_view AS
SELECT m.title      AS movie,
       a.name       AS task,
       v.date_value AS due_date
FROM movies m
         JOIN
     attributes a ON m.id = a.movie_id
         JOIN
     values v ON a.id = v.attribute_id
WHERE a.attribute_type_id = (SELECT id FROM attribute_types WHERE name = 'служебные даты')
  AND v.date_value >= CURRENT_DATE
  AND v.date_value <= CURRENT_DATE +
        INTERVAL '20 days'
        ORDER BY
        v.date_value;
```

#### Представление для маркетинговых данных

```sql
DROP VIEW IF EXISTS marketing_data_view;

CREATE VIEW marketing_data_view AS
SELECT m.title AS movie,
       at.name AS attribute_type,
       a.name  AS attribute,
       COALESCE(v.text_value, v.boolean_value ::text, v.date_value ::text, v.float_value ::text) AS value
FROM 
    movies m
JOIN 
    attributes a ON m.id = a.movie_id
JOIN 
    attribute_types at ON a.attribute_type_id = at.id
JOIN 
    values v ON a.id = v.attribute_id
ORDER BY 
    m.title, at.name, a.name;

```

### Проверка данных

#### Проверка содержимого таблиц

```sql
-- Фильмы
SELECT *
FROM movies;

-- Типы атрибутов
SELECT *
FROM attribute_types;

-- Атрибуты
SELECT *
FROM attributes;

-- Значения
SELECT *
FROM values;
```

#### Проверка представлений

```sql
-- Проверка service_tasks_view
SELECT *
FROM service_tasks_view;

-- Проверка marketing_data_view
SELECT *
FROM marketing_data_view;
```

### Ожидаемые результаты

`service_tasks_view`

| movie	                   | task                           | 	due_date   |
|--------------------------|--------------------------------|-------------|
| The Shawshank Redemption | 	Дата начала продажи билетов	  | 1994-08-01  
| The Shawshank Redemption | 	Когда запускать рекламу на ТВ | 	1994-07-01 
| The Godfather            | 	Дата начала продажи билетов   | 	1972-02-01 
| The Godfather            | 	Когда запускать рекламу на ТВ | 	1972-01-01 
| Pulp Fiction             | 	Дата начала продажи билетов   | 	1994-04-01 
| Pulp Fiction             | 	Когда запускать рекламу на ТВ | 	1994-03-01 

`marketing_data_view`

| movie                    | attribute_type  | attribute                      | value                                       |
|--------------------------|-----------------|--------------------------------|---------------------------------------------|
| The Shawshank Redemption | 	рецензии       | 	Рецензия критиков             | 	An inspiring story of hope and friendship. 
| The Shawshank Redemption | 	премия         | 	Оскар                         | 	false                                      
| The Shawshank Redemption | 	важные даты    | 	Мировая премьера              | 	1994-09-10                                 
| The Shawshank Redemption | 	служебные даты | 	Дата начала продажи билетов   | 	1994-08-01                                 
| The Shawshank Redemption | 	служебные даты | 	Когда запускать рекламу на ТВ | 	1994-07-01                                 
| The Godfather            | 	рецензии       | 	Рецензия критиков             | 	A masterpiece of crime drama.              
| The Godfather            | 	премия         | 	Оскар                         | 	true                                       
| The Godfather            | 	важные даты    | 	Мировая премьера              | 	1972-03-15                                 
| The Godfather            | 	служебные даты | 	Дата начала продажи билетов   | 	1972-02-01                                 
| The Godfather            | 	служебные даты | 	Когда запускать рекламу на ТВ | 	1972-01-01                                 
| Pulp Fiction             | 	рецензии       | 	Рецензия критиков             | 	A wildly original and entertaining film.   
| Pulp Fiction             | 	премия         | 	Оскар                         | 	true                                       
| Pulp Fiction             | 	важные даты    | 	Мировая премьера              | 	1994-05-21                                 
| Pulp Fiction             | 	служебные даты | 	Дата начала продажи билетов   | 	1994-04-01                                 
| Pulp Fiction             | 	служебные даты | 	Когда запускать рекламу на ТВ | 	1994-03-01                                 
