CREATE TABLE `Movies` (
	`id`	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	`name`	VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE Attribute_types
(
    `id`	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    `name`	VARCHAR(120) NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
);

CREATE TABLE Attributes
(
    `id`				INTEGER 	NOT NULL 	AUTO_INCREMENT UNIQUE,
    `attribute_type_id`	INTEGER 	NOT NULL 	REFERENCES Attribute_types (id) ON DELETE CASCADE,
	`name` 				VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE Values
(
    `id`				INTEGER 	NOT NULL 	AUTO_INCREMENT UNIQUE,
	`movie_id`			INTEGER 	NOT NULL 	REFERENCES Movies (id) ON DELETE CASCADE,
    `attribute_id`   	INTEGER 	NOT NULL 	REFERENCES Attribute (id) ON DELETE CASCADE,
	`value`				TEXT		NOT NULL
	PRIMARY KEY(`id`)
);

CREATE INDEX idx_attribute_type_movie ON Attributes (attribute_type_id);