CREATE TABLE film (
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL,
    "date" DATE NOT NULL
);

CREATE TABLE attribute (
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL
);

CREATE TABLE attribute_type(
    "id" SERIAL PRIMARY KEY,
    "title" VARCHAR(255) NOT NULL,
    "data_type" VARCHAR(255) NOT NULL,
    attribute_id INT NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES attribute("id")
);

ALTER TABLE attribute_type ADD CONSTRAINT attribute_id_type UNIQUE (title, attribute_id);

CREATE TABLE attribute_value(
    "id" SERIAL PRIMARY KEY,
    "value_string" VARCHAR(255) DEFAULT NULL,
    "value_text" TEXT DEFAULT NULL,
    "value_int" INT DEFAULT NULL,
    "value_float" FLOAT DEFAULT NULL,
    "value_date" DATE DEFAULT NULL,
    "attribute_id" INT NOT NULL,
    "film_id" INT NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES attribute("id"),
    FOREIGN KEY (film_id) REFERENCES film("id")
);

CREATE INDEX film_attribute_value_string ON attribute_value("value_string");
CREATE INDEX film_attribute_value_text ON attribute_value("value_text");
CREATE INDEX film_attribute_value_int ON attribute_value("value_int");
CREATE INDEX film_attribute_value_float ON attribute_value("value_float");
CREATE INDEX film_attribute_value_date ON attribute_value("value_date");
