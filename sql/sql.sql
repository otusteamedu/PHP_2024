CREATE TABLE IF NOT EXISTS films
(
    id   bigint PRIMARY KEY,
    name varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS attribute_types
(
    id   bigint PRIMARY KEY,
    name varchar(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS attributes
(
    id                bigint PRIMARY KEY,
    name              varchar(100) NOT NULL,
    attribute_type_id int          NOT NULL,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);

CREATE TABLE IF NOT EXISTS attribute_values
(
    films_id     int NOT NULL,
    attribute_id int NOT NULL,
    value_int    integer,
    value_text   text,
    value_date   date,
    value_number numeric,
    value_bool   bool,
    PRIMARY KEY (films_id, attribute_id),
    FOREIGN KEY (films_id) REFERENCES films (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);

CREATE VIEW marketing AS
SELECT m.name                        as film_name,
       at.name                       as attribute_type,
       a.name                        as attribute_name,
       COALESCE(av.value_int::TEXT, av.value_text, av.value_date::TEXT, av.value_number::TEXT,
                av.value_bool::TEXT) as value
FROM films m
         JOIN attribute_values av ON m.id = av.films_id
         JOIN attributes a ON av.attribute_id = a.id
         JOIN attribute_types at ON a.attribute_type_id = at.id;

CREATE VIEW tasks AS
SELECT m.name                        as film_name,
       a.name                        as attribute_name,
       COALESCE(av.value_int::TEXT, av.value_text, av.value_date::TEXT, av.value_number::TEXT,
                av.value_bool::TEXT) as value
FROM films m
         JOIN attribute_values av ON m.id = av.films_id
         JOIN attributes a ON av.attribute_id = a.id
WHERE a.name = 'task_date'
  AND (av.value_date = CURRENT_DATE OR av.value_date = CURRENT_DATE + INTERVAL '20 day');

