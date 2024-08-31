create table if not exists cinema
(
    id           serial
        primary key,
    name         varchar(255) not null,
    address      varchar(255) not null,
    phone_number varchar(20)
);

create table if not exists hall
(
    id        serial
        primary key,
    cinema_id integer
        references cinema,
    name      varchar(255) not null,
    capacity  integer      not null
);

create table if not exists seat
(
    id      serial
        primary key,
    hall_id integer
        references hall,
    row     integer not null,
    number  integer not null
);

create table if not exists picture_type
(
    id   serial
        primary key,
    name varchar(4) not null
);

create table if not exists rating
(
    id   serial
        primary key,
    name varchar(3) not null
);

create table if not exists movie
(
    id        serial
        primary key,
    rating_id integer      not null
        references rating,
    title     varchar(255) not null,
    duration  integer      not null
);

create table if not exists genre
(
    id       serial
        primary key,
    movie_id integer      not null
        references movie,
    name     varchar(255) not null
);

create table if not exists review
(
    id       serial
        primary key,
    movie_id integer    not null
        references movie,
    score    varchar(3) not null
);

create table if not exists show
(
    id               serial
        primary key,
    hall_id          integer        not null
        references hall,
    movie_id         integer        not null
        references movie,
    picture_type_id  integer        not null
        references picture_type,
    date             date           not null,
    time             time           not null,
    price_per_ticket numeric(10, 2) not null
);

create table if not exists ticket
(
    id            serial
        primary key,
    show_id       integer   not null
        references show,
    seat_id       integer   not null
        references seat,
    purchase_time timestamp not null
);

