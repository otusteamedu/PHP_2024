# EAVCINEMA Database Schema

## Таблицы

'''sql
-- Создание таблицы films
CREATE TABLE films (
    film_id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year INT
);

-- Создание таблицы attribute_types
CREATE TABLE attribute_types (
    attribute_type_id INT PRIMARY KEY,
    type_name VARCHAR(50) NOT NULL
);

-- Создание таблицы attributes
CREATE TABLE attributes (
    attribute_id INT PRIMARY KEY,
    attribute_name VARCHAR(255) NOT NULL,
    attribute_type_id INT,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types(attribute_type_id)
);

-- Создание таблицы attribute_values
CREATE TABLE attribute_values (
    film_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value_text TEXT,
    value_date DATE,
    value_boolean BOOLEAN,
    value_image BLOB,
    value_int INT,
    value_float FLOAT,
    value_decimal DECIMAL(15,4),
    PRIMARY KEY (film_id, attribute_id),
    FOREIGN KEY (film_id) REFERENCES films(film_id),
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)
);

-- Создание таблицы important_dates
CREATE TABLE important_dates (
    film_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value_date DATE NOT NULL,
    PRIMARY KEY (film_id, attribute_id),
    FOREIGN KEY (film_id) REFERENCES films(film_id),
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)
);

-- Создание таблицы service_dates
CREATE TABLE service_dates (
    film_id INT NOT NULL,
    attribute_id INT NOT NULL,
    value_date DATE NOT NULL,
    PRIMARY KEY (film_id, attribute_id),
    FOREIGN KEY (film_id) REFERENCES films(film_id),
    FOREIGN KEY (attribute_id) REFERENCES attributes(attribute_id)
);
'''

## Представления

1. **marketing_data**
   Сбор данных для маркетинга, фильтруя только текстовые атрибуты (например, рецензии).

   ```sql
   CREATE VIEW marketing_data AS
   SELECT 
       f.title AS film, 
       at.attribute_name AS attribute_type,
       av.value_text AS attribute_value
   FROM films f
   JOIN attribute_values av ON f.film_id = av.film_id
   JOIN attributes at ON av.attribute_id = at.attribute_id
   WHERE at.attribute_type_id = (SELECT attribute_type_id FROM attribute_types WHERE type_name = 'Текст');
