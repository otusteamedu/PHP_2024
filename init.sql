create table if not exists movie
(
    id    serial primary key,
    title varchar(255) unique
);

create table if not exists attribute_type
(
    id        serial primary key,
    type_name varchar(255) unique
);

create table if not exists attribute
(
    id      serial primary key,
    title   varchar(255) unique,
    name    varchar(255) unique,
    type_id integer references attribute_type (id)
);

create table if not exists attribute_value
(
    id              serial primary key,
    attribute_id    integer references attribute (id),
    movie_id        integer references movie (id),
    text_value      text      default null,
    bool_value      bool      default null,
    timestamp_value timestamp default null,
    float_value     float     default null
);

create table if not exists hall
(
    id    serial primary key,
    title varchar(255) not null,
    rows  integer check ( rows > 0 ),
    cols  integer check ( cols > 0)
);

create table if not exists session
(
    id            serial primary key,
    movie_id      integer references movie (id),
    hall_id       integer references hall (id),
    start_time    timestamp,
    end_time      timestamp,
    ticket_count  integer default 0,
    earned_money integer default 0
);

create table if not exists ticket
(
    id         serial primary key,
    session_id integer references session (id),
    raw        integer not null,
    col        integer not null,
    price      float   not null
);