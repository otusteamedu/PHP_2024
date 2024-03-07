-- Кинозалы
CREATE TABLE IF NOT EXISTS hall
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE hall IS 'Кинозал';
COMMENT ON COLUMN hall.name IS 'Название кинозала';

-- Фильмы
CREATE TABLE IF NOT EXISTS movie
(
    id          SERIAL PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description text DEFAULT NULL
);
COMMENT ON TABLE movie IS 'Фильмы';
COMMENT ON COLUMN movie.name IS 'Название фильма';
COMMENT ON COLUMN movie.description IS 'Описание фильма';

-- Стоимость фильмов
CREATE TABLE IF NOT EXISTS movie_price
(
    id          SERIAL PRIMARY KEY,
    movie_id    integer NOT NULL,
    price       integer NOT NULL,
    type        varchar(60) NOT NULL,
    started_at  date NOT NULL,
    CONSTRAINT fk_movie
        FOREIGN KEY (movie_id)
            REFERENCES movie (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
COMMENT ON TABLE movie_price IS 'Цены фильмов';
COMMENT ON COLUMN movie_price.movie_id IS 'Ссылка на фильм';
COMMENT ON COLUMN movie_price.type IS 'Тип цены';
COMMENT ON COLUMN movie_price.started_at IS 'Дата начала действия цены';

CREATE INDEX IF NOT EXISTS fk_movie_price_movie_movie_id ON movie_price (movie_id);

-- Сидения
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
            ON UPDATE CASCADE
);
COMMENT ON TABLE seat IS 'Сидения';
COMMENT ON COLUMN seat.number IS 'Номер сидения';
COMMENT ON COLUMN seat.row IS 'Ряд сидения';
COMMENT ON COLUMN seat.hall_id IS 'Ссылка на кинозал';

CREATE INDEX IF NOT EXISTS fk_seat_hall_hall_id ON seat (hall_id);

-- Сеансы
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
            ON UPDATE CASCADE
);
COMMENT ON TABLE session IS 'Сидения';
COMMENT ON COLUMN session.hall_id IS 'Ссылка на кинозал';
COMMENT ON COLUMN session.movie_id IS 'Ссылка на фильм';
COMMENT ON COLUMN session.scheduled_at IS 'Время и дата начала сеанса';
COMMENT ON COLUMN session.duration IS 'Длительность сеанса в секундах';

CREATE INDEX IF NOT EXISTS fk_session_hall_hall_id ON session (hall_id);
CREATE INDEX IF NOT EXISTS fk_session_movie_movie_id ON session (movie_id);

-- Билеты
CREATE TABLE IF NOT EXISTS ticket
(
    id         SERIAL PRIMARY KEY,
    seat_id    int       NOT NULL,
    session_id int       NOT NULL,
    is_sold    bool      NOT NULL,
    CONSTRAINT fk_seat
        FOREIGN KEY (seat_id)
            REFERENCES seat (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_session
        FOREIGN KEY (session_id)
            REFERENCES session (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
COMMENT ON TABLE ticket IS 'Билеты на сеанс';
COMMENT ON COLUMN ticket.seat_id IS 'Ссылка на сидение';
COMMENT ON COLUMN ticket.session_id IS 'Ссылка на сеанс';
COMMENT ON COLUMN ticket.is_sold IS 'Флаг, указывающий продан ли билет';

CREATE INDEX IF NOT EXISTS fk_session_seat_seat_id ON ticket (seat_id);
CREATE INDEX IF NOT EXISTS fk_ticket_session_session_id ON ticket (session_id);

-- Продажи билетов
CREATE TABLE IF NOT EXISTS ticket_sale
(
    id         SERIAL PRIMARY KEY,
    ticket_id    int       NOT NULL,
    amount       int       NOT NULL,
    CONSTRAINT fk_ticket
        FOREIGN KEY (ticket_id)
            REFERENCES ticket (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
COMMENT ON TABLE ticket_sale IS 'Продажи билетов';
COMMENT ON COLUMN ticket_sale.ticket_id IS 'Ссылка на билет';
COMMENT ON COLUMN ticket_sale.amount IS 'Стоимость билета';

CREATE INDEX IF NOT EXISTS fk_ticket_ticket_sale_ticket_id ON ticket_sale (ticket_id);
