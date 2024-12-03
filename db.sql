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
    attribute_id INT NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES attribute("id")
);

ALTER TABLE attribute_type ADD CONSTRAINT attribute_id_type UNIQUE (title, attribute_id);

CREATE TABLE attribute_value(
    "id" SERIAL PRIMARY KEY,
    "value" VARCHAR(255) NOT NULL,
    "attribute_id" INT NOT NULL,
    "film_id" INT NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES attribute("id"),
    FOREIGN KEY (film_id) REFERENCES film("id")
);

CREATE INDEX film_attribute_value ON attribute_value("value", "attribute_id", "film_id");
