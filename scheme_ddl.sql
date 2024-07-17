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
    primary key,
    title    varchar(100),
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
    references clients
    );
