CREATE TABLE movie
(
    id          serial PRIMARY KEY,
    name        varchar(255) UNIQUE NOT NULL,
    description text,
    duration    integer             NOT NULL
);

COMMENT ON COLUMN movie.duration IS 'Длительность в минутах';

CREATE TABLE cinema_hall
(
    id     serial PRIMARY KEY,
    name   varchar(255) UNIQUE NOT NULL,
    active bool                NOT NULL
);

CREATE TABLE movie_showing
(
    id             serial PRIMARY KEY,
    cinema_hall_id integer NOT NULL,
    movie_id       integer NOT NULL,
    begin_date     date    NOT NULL,
    end_date       date    NOT NULL,
    active         bool    NOT NULL,
    CONSTRAINT fk_cinema_hall
        foreign key (cinema_hall_id)
            REFERENCES cinema_hall (id),
    CHECK ( begin_date < end_date )
);

CREATE TABLE movie_showing_schedule
(
    id               serial PRIMARY KEY,
    day_of_week      integer NOT NULL CHECK (day_of_week >= 1 AND day_of_week <= 7),
    movie_showing_id integer NOT NULL,
    price            numeric NOT NULL CHECK (price > 0),
    begin_time       time    NOT NULL,
    end_time         time    NOT NULL,
    CONSTRAINT fk_movie_showing
        foreign key (movie_showing_id)
            REFERENCES movie_showing (id),
    CHECK ( begin_time < end_time )
);

CREATE TABLE seat
(
    id             serial PRIMARY KEY,
    cinema_hall_id integer NOT NULL,
    row_number     integer NOT NULL,
    column_number  integer NOT NULL,
    price_ratio    real    NOT NULL DEFAULT 1 CHECK (price_ratio > 0),
    active         bool,
    CONSTRAINT fk_cinema_hall
        foreign key (cinema_hall_id)
            REFERENCES cinema_hall (id),
    UNIQUE (cinema_hall_id, row_number, column_number)
);

COMMENT ON COLUMN seat.price_ratio IS 'Коэффициент стоимости места';

CREATE TABLE ticket
(
    id                        serial PRIMARY KEY,
    movie_showing_schedule_id integer NOT NULL,
    seat_id                   integer NOT NULL,
    date_show                 date    NOT NULL,
    price                     numeric NOT NULL,
    CONSTRAINT fk_movie_showing_schedule
        foreign key (movie_showing_schedule_id)
            REFERENCES movie_showing_schedule (id),
    CONSTRAINT fk_seat
        foreign key (seat_id)
            REFERENCES seat (id),
    UNIQUE (movie_showing_schedule_id, seat_id, date_show)
);
