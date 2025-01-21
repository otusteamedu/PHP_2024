-- ТАБЛИЦЫ

create table if not exists clients
(
    id   serial primary key,
    name varchar(255) not null
    );

create table if not exists countries
(
    id   serial primary key,
    name varchar(255) not null
    );

create table if not exists films
(
    id         serial primary key,
    name       varchar(255) not null,
    year       int          not null,
    start_date timestamp    not null
    );

create table if not exists country_film
(
    country_id integer references countries (id),
    film_id    integer references films (id)
    );

CREATE TYPE hall_types AS ENUM ('IMAX', 'COMMON', '3D');

create table if not exists halls
(
    id   serial primary key,
    name varchar(255) not null,
    type hall_types
    );

create table if not exists hall_seats
(
    id                serial primary key,
    hall_id           integer references halls (id),
    number            varchar(255)  not null,
    price_coefficient decimal(8, 2) not null,
    max_count         int           not null,
    constraint hall_seats_hall_id_foreign
    foreign key (hall_id) references halls (id)
    on delete cascade
    );

create table if not exists times
(
    id   serial primary key,
    time time not null
    );

create table if not exists sessions
(
    id      serial primary key,
    hall_id integer references halls (id),
    film_id integer references films (id),
    time_id integer references times (id),
    date    timestamp     not null,
    price   decimal(8, 2) not null
    );

create table if not exists tickets
(
    id                     serial primary key,
    client_id              integer references clients (id),
    session_id             integer references sessions (id),
    hall_seat_id           integer references hall_seats (id),
    session_price          decimal(8, 2) not null,
    seat_price_coefficient decimal(8, 2) not null
);