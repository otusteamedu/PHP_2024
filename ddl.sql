create table cinema
(
    id   serial primary key,
    name varchar(255)
);

create table hall
(
    id        serial primary key,
    name      varchar(255),
    capacity  smallint,
    cinema_id bigint references cinema (id)
);

create table directors
(
    id   serial primary key,
    name varchar(255)
);

create table movies
(
    id           serial primary key,
    name         varchar(255),
    duration     smallint,
    release_year smallint,
    director_id  bigint references directors (id),
    genre        varchar(255)
);

create table sessions
(
    id         serial primary key,
    movie_id   bigint references movies (id),
    hall_id    bigint references hall (id),
    price      integer,
    start_time timestamp,
    end_time   timestamp
);

create table actors
(
    id   serial primary key,
    name varchar(255)
);

create table movies_actors
(
    movie_id bigint references movies (id),
    actor_id bigint references actors (id)
);

create table seats
(
    id          serial primary key,
    seat_number integer not null,
    row_number  integer not null,
    hall_id     bigint references hall (id)
);

create table tickets
(
    id            serial primary key,
    price         integer,
    purchase_time timestamp,
    session_id    bigint references sessions (id),
    seat_id       bigint references seats (id),
);

create table buyer
(
    id       serial primary key,
    fullname varchar(255),
    phone    varchar(255)
);

create table orders
(
    id         serial primary key,
    buyer_id   bigint references buyer (id),
    ticket_id  bigint references tickets (id),
    created_at timestamp
);
