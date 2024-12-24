CREATE TABLE `Movies` (
	`id`	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name`	VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE `Attribute_types`
(
    `id`	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    `name`	VARCHAR(120) NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
);

CREATE TABLE `Attributes`
(
    `id`				INTEGER 	NOT NULL 	AUTO_INCREMENT UNIQUE,
    `attribute_type_id`	INTEGER 	NOT NULL 	REFERENCES Attribute_types (id) ON DELETE CASCADE,
	`name` 				VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE `Values`
(
    `id`				INTEGER 	NOT NULL 	AUTO_INCREMENT UNIQUE,
	`movie_id`			INTEGER 	NOT NULL 	REFERENCES Movies (id) ON DELETE CASCADE,
    `attribute_id`   	INTEGER 	NOT NULL 	REFERENCES Attributes (id) ON DELETE CASCADE,
	`value_text`      	TEXT  					DEFAULT NULL,
    `value_boolean`   	BOOLEAN  				DEFAULT NULL,
    `value_date`      	DATE  					DEFAULT NULL,
    `value_timestamp` 	TIMESTAMP  				DEFAULT NULL,
    `value_float` 	    FLOAT  				    DEFAULT NULL,
	PRIMARY KEY(`id`)
);

CREATE INDEX idx_attribute_type_movie ON `Attributes` (attribute_type_id);
CREATE INDEX idx_value_by_date ON `Values` (value_timestamp);