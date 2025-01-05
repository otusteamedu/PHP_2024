-- EAV модель
CREATE TABLE IF NOT EXISTS
attribute_types (
    type_id     serial PRIMARY KEY,
    name        varchar(255) NOT NULL,
    data_type   varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS
attributes (
    attribute_id    serial PRIMARY KEY,
    film_id         int NOT NULL REFERENCES films (film_id),
    name            varchar(255) NOT NULL,
    type_id         int NOT NULL REFERENCES attribute_types (type_id)
);

CREATE TABLE IF NOT EXISTS
attributes_values (
    attr_value_id   serial PRIMARY KEY,
    attribute_id    int NOT NULL REFERENCES attributes (attribute_id),
    value_boolean   boolean NULL DEFAULT NULL,
    value_integer   int NULL DEFAULT NULL,
    value_float     float NULL DEFAULT NULL,
    value_decimal   DECIMAL(12, 2) NULL DEFAULT NULL,
    value_date      date NULL DEFAULT NULL,
    value_timestamp TIMESTAMP NULL DEFAULT NULL,
    value_varchar   varchar NULL DEFAULT NULL,
    value_text      text NULL DEFAULT NULL
);

CREATE INDEX idx_attribute_types ON attribute_types (type_id);
CREATE INDEX idx_attributes ON attributes (attribute_id, film_id, type_id);
CREATE INDEX idx_attributes_values ON attributes_values (attribute_id);
CREATE INDEX idx_attributes_values_dates ON attributes_values (value_date, value_timestamp);