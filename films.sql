DROP TABLE IF EXISTS films;
CREATE TABLE films (
    id SERIAL PRIMARY KEY, 
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS attribute_types;
CREATE TABLE attribute_types (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255)
);

DROP TABLE IF EXISTS attributes;
CREATE TABLE attributes (
    id SERIAL PRIMARY KEY,  
    name CHARACTER VARYING(255),
    attribute_type_id INTEGER,
    FOREIGN KEY (attribute_type_id) REFERENCES attribute_types (id)
);

DROP TABLE IF EXISTS values;
CREATE TABLE values (
    film_id INTEGER, 
    attribute_id INTEGER,
    value_int INTEGER,
    value_dec DECIMAL(10, 2),
    value_text TEXT,
    value_date DATE,
    value_bool BOOLEAN,
    FOREIGN KEY (film_id) REFERENCES films (id),
    FOREIGN KEY (attribute_id) REFERENCES attributes (id)
);
