CREATE TABLE IF NOT EXISTS hall
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE hall IS 'Кинозал';
COMMENT ON COLUMN hall.name IS 'Название кинозала';

CREATE TABLE IF NOT EXISTS movie
(
    id          SERIAL PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description text DEFAULT NULL
);
COMMENT ON TABLE movie IS 'Фильмы';
COMMENT ON COLUMN movie.name IS 'Название фильма';
COMMENT ON COLUMN movie.description IS 'Описание фильма';

CREATE TABLE IF NOT EXISTS seat
(
    id      SERIAL PRIMARY KEY,
    number  int NOT NULL,
    row     int NOT NULL,
    hall_id int NOT NULL,
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES hall (id)
            ON DELETE CASCADE
);
COMMENT ON TABLE seat IS 'Сидения';
COMMENT ON COLUMN seat.number IS 'Номер сидения';
COMMENT ON COLUMN seat.row IS 'Ряд сидения';
COMMENT ON COLUMN seat.hall_id IS 'Ссылка на кинозал';

CREATE TABLE IF NOT EXISTS session
(
    id           SERIAL PRIMARY KEY,
    hall_id      int       NOT NULL,
    movie_id     int       NOT NULL,
    scheduled_at timestamp NOT NULL,
    duration     int       NOT NULL,
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES hall (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_movie
        FOREIGN KEY (movie_id)
            REFERENCES movie (id)
            ON DELETE CASCADE
);
COMMENT ON TABLE session IS 'Сидения';
COMMENT ON COLUMN session.hall_id IS 'Ссылка на кинозал';
COMMENT ON COLUMN session.movie_id IS 'Ссылка на фильм';
COMMENT ON COLUMN session.scheduled_at IS 'Время и дата начала сеанса';
COMMENT ON COLUMN session.duration IS 'Длительность сеанса в секундах';
