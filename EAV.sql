CREATE database db_cinema;

DROP TABLE IF EXISTS `films`;

CREATE TABLE `films`
(
    `id`    SERIAL PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `type_attr`;

CREATE TABLE `type_attr`
(
    `id`  SERIAL PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `attrs`;

CREATE TABLE `attrs`
(
    `id`      SERIAL PRIMARY KEY,
    `name`    VARCHAR(100) NOT NULL,
    `type_id` INT  NOT NULL REFERENCES type_attr (id)
);

DROP TABLE IF EXISTS `film_attr_values`;

CREATE TABLE `film_attr_values`
(
    `film_id`     INT NOT NULL REFERENCES films (id),
    `attr_id` INT NOT NULL REFERENCES attrs (id),
    `value_int`    INTEGER,
    `value_text`   TEXT,
    `value_date`   DATE,
    `value_number` NUMERIC,
    `value_bool`   BOOLEAN,
    PRIMARY KEY (film_id, attr_id)
);