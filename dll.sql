-- movies.films определение

-- Drop table

DROP TABLE IF EXISTS films;

CREATE TABLE movies.films (
	id serial4 NOT NULL,
	title varchar(255) NOT NULL,
	CONSTRAINT films_pkey PRIMARY KEY (id)
);


-- movies.films_attribute_types определение

-- Drop table

DROP TABLE IF EXISTS films_attribute_types;

CREATE TABLE movies.films_attribute_types (
	id serial4 NOT NULL,
	"type" varchar(255) NOT NULL,
	CONSTRAINT films_attribute_types_pkey PRIMARY KEY (id)
);


-- movies.films_attributes определение

-- Drop table

DROP TABLE IF EXISTS films_attributes;

CREATE TABLE movies.films_attributes (
	id serial4 NOT NULL,
	"name" varchar(255) NOT NULL,
	type_id int4 NOT NULL,
	code varchar NULL,
	CONSTRAINT films_attributes_pkey PRIMARY KEY (id),
	CONSTRAINT films_attributes_unique UNIQUE (code),
	CONSTRAINT films_attributes_films_attribute_types_fk FOREIGN KEY (type_id) REFERENCES movies.films_attribute_types(id)
);


-- movies.films_values определение

-- Drop table

DROP TABLE IF EXISTS films_values;

CREATE TABLE movies.films_values (
	id serial4 NOT NULL,
	film_id int4 NOT NULL,
	attribute_id int4 NOT NULL,
	value_varchar varchar(255) NULL,
	value_text text NULL,
	value_date date NULL,
	value_int int4 NULL,
	value_bool bool NULL,
	value_numeric numeric(10, 4) NULL,
	CONSTRAINT films_values_pkey PRIMARY KEY (id),
	CONSTRAINT films_values_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES movies.films_attributes(id),
	CONSTRAINT films_values_film_id_fkey FOREIGN KEY (film_id) REFERENCES movies.films(id)
);

