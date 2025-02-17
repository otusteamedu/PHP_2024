-- Создание схемы EAVCINEMA
CREATE SCHEMA EAVCINEMA;

-- Использование схемы EAVCINEMA
USE EAVCINEMA;

-- Таблица для хранения фильмов
CREATE TABLE films (
    film_id INT PRIMARY KEY AUTO_INCREMENT,  -- Уникальный идентификатор фильма
    title VARCHAR(255) NOT NULL,             -- Название фильма
    release_year INT                        -- Год выпуска фильма
);

-- Таблица для типов атрибутов
CREATE TABLE attribute_types (
    attribute_type_id INT PRIMARY KEY AUTO_INCREMENT,  -- Уникальный идентификатор типа атрибута
    type_name VARCHAR(50) NOT NULL                     -- Тип атрибута (Текст, Логический, Дата, Изображение)
);

-- Таблица для хранения атрибутов
CREATE TABLE attributes (
    attribute_id INT PRIMARY KEY AUTO_INCREMENT,       -- Уникальный идентификатор атрибута
    attribute_name VARCHAR(255) NOT NULL,               -- Название атрибута (например, Рецензия, Премия)
    attribute_type_id INT,                             -- Идентификатор типа атрибута (связь с таблицей attribute_types)
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types(attribute_type_id)  -- Внешний ключ на тип атрибута
);

-- Таблица для хранения значений атрибутов (ключевая таблица EAV)
CREATE TABLE attribute_values (
    film_id INT,                                      -- Идентификатор фильма
    attribute_id INT,                                 -- Идентификатор атрибута
    value_text TEXT,                                  -- Для текстовых значений
    value_date DATE,                                  -- Для значений даты
    value_boolean BOOLEAN,                            -- Для логических значений
    value_image BLOB,                                 -- Для изображений (например, для премий)
    PRIMARY KEY (film_id, attribute_id),              -- Составной первичный ключ
    FOREIGN KEY (film_id) REFERENCES films(film_id),  -- Внешний ключ на фильм
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)  -- Внешний ключ на атрибут
);

-- Таблица для важнейших атрибутов типа 'Дата'
CREATE TABLE important_dates (
    film_id INT,                                      -- Идентификатор фильма
    attribute_id INT,                                 -- Идентификатор атрибута (например, премьера)
    value_date DATE,                                  -- Дата значений
    PRIMARY KEY (film_id, attribute_id),              -- Составной первичный ключ
    FOREIGN KEY (film_id) REFERENCES films(film_id),  -- Внешний ключ на фильм
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)  -- Внешний ключ на атрибут
);

-- Таблица для служебных атрибутов (например, даты начала продаж билетов, запуска рекламы)
CREATE TABLE service_dates (
    film_id INT,                                      -- Идентификатор фильма
    attribute_id INT,                                 -- Идентификатор атрибута
    value_date DATE,                                  -- Дата значений
    PRIMARY KEY (film_id, attribute_id),              -- Составной первичный ключ
    FOREIGN KEY (film_id) REFERENCES films(film_id),  -- Внешний ключ на фильм
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)  -- Внешний ключ на атрибут
);

-- Представление для сбора данных для маркетинга
CREATE VIEW marketing_data AS
SELECT 
    f.title AS film,                                  -- Название фильма
    at.attribute_name AS attribute_type,              -- Тип атрибута (например, Рецензия, Премия)
    av.value_text AS attribute_value                  -- Значение атрибута (например, текст рецензии)
FROM 
    films f
JOIN 
    attribute_values av ON f.film_id = av.film_id
JOIN 
    attributes at ON av.attribute_id = at.attribute_id
WHERE 
    at.attribute_type_id = (SELECT attribute_type_id FROM attribute_types WHERE type_name = 'Текст');  -- Только текстовые атрибуты (например, рецензии)

-- Представление для сбора служебных задач (актуальные на сегодня)
CREATE VIEW service_tasks_today AS
SELECT 
    f.title AS film,                                  -- Название фильма
    sd.value_date AS task_date                        -- Дата задачи (например, дата начала продаж билетов)
FROM 
    films f
JOIN 
    service_dates sd ON f.film_id = sd.film_id
WHERE 
    sd.value_date = CURRENT_DATE;  -- Задачи актуальные на сегодня

-- Представление для сбора задач, актуальных через 20 дней
CREATE VIEW service_tasks_20_days AS
SELECT 
    f.title AS film,                                  -- Название фильма
    sd.value_date AS task_date                        -- Дата задачи (например, дата начала продаж билетов)
FROM 
    films f
JOIN 
    service_dates sd ON f.film_id = sd.film_id
WHERE 
    sd.value_date = DATE_ADD(CURRENT_DATE, INTERVAL 20 DAY);  -- Задачи актуальные через 20 дней