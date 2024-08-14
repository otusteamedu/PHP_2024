CREATE TABLE movies
(
    id   serial       not null
        constraint movies_pkey
            primary key,
    name varchar(255) not null
);

CREATE TABLE attributes_types
(
    id   serial       not null
        constraint attributes_types_pkey
            primary key,
    name varchar(255) not null
);

CREATE TABLE attributes_names
(
    id                  serial not null
        constraint attributes_names_pkey
            primary key,
    name                varchar(255),
    attributes_types_id integer
        constraint attributes_names_attributes_types_id_fkey
            references attributes_types
);

CREATE INDEX ON attributes_names (attributes_types_id);

CREATE TABLE attributes_values
(
    id                  serial not null
        constraint attributes_values_pkey
            primary key,
    movies_id           integer
        constraint attributes_values_movies_id_fkey
            references movies,
    attributes_names_id integer
        constraint attributes_values_attributes_names_id_fkey
            references attributes_names,
    value_text          text,
    value_int           integer,
    value_bool          boolean,
    value_date          date,
    value_numeric       numeric(10, 2)
);

CREATE INDEX ON attributes_values (movies_id);
CREATE INDEX ON attributes_values (attributes_names_id);