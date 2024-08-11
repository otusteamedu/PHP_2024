create table if not exists halls
(
    id       integer not null
    primary key,
    name     varchar(50),
    capacity integer
    );


create table if not exists movies
(
    id       serial
    primary key,  title    varchar(100),
    genre    varchar(50),
    duration integer
    );


create table if not exists clients
(
    id    integer not null
    primary key,
    name  varchar(100),
    phone varchar(12)
    );

create table if not exists seats
(
    id          serial
    primary key,
    hall_id     integer
    references halls,
    row_number  integer,
    seat_number integer
);

create table if not exists sessions
(
    id         serial
        primary key,
    hall_id    integer
        references halls,
    movie_id   integer
        references movies,
    start_time timestamp,
    end_time   date
);

create table if not exists tickets
(
    id         serial
    primary key,
    session_id integer
    references sessions,
    seat_id    integer
    references seats,
    price      numeric(10, 2),
    status     varchar(10),
    client_id  integer
    references clients,
    date       date
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