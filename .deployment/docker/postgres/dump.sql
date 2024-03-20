-- Кинозалы
CREATE TABLE IF NOT EXISTS hall
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL,
    capacity int NOT NULL,
    rows_count int NOT NULL
);
COMMENT ON TABLE hall IS 'Кинозал';
COMMENT ON COLUMN hall.name IS 'Название кинозала';
COMMENT ON COLUMN hall.capacity IS 'Общее количество сидений, вместимость зала';
COMMENT ON COLUMN hall.rows_count IS 'Количество рядов в зале';

-- Страны-производители фильмов
CREATE TABLE IF NOT EXISTS country
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE country IS 'Страны-производители фильмов';
COMMENT ON COLUMN country.name IS 'Название страны';

-- Жанры фильмов
CREATE TABLE IF NOT EXISTS genre
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL
);
COMMENT ON TABLE genre IS 'Жанры фильмов';
COMMENT ON COLUMN genre.name IS 'Название жанра';

-- Фильмы
CREATE TABLE IF NOT EXISTS movie
(
    id          SERIAL PRIMARY KEY,
    name        varchar(255) NOT NULL,
    description text DEFAULT NULL,
    country_id  int          NOT NULL,
    produced_at date         NOT NULL
);
COMMENT ON TABLE movie IS 'Фильмы';
COMMENT ON COLUMN movie.name IS 'Название фильма';
COMMENT ON COLUMN movie.description IS 'Описание фильма';
COMMENT ON COLUMN movie.country_id IS 'Ссылка на страну-производитель фильма';
COMMENT ON COLUMN movie.produced_at IS 'Дата выпуска фильма';

-- Многие ко многим для жанров и фильмов
CREATE TABLE IF NOT EXISTS movie_genre
(
    movie_id int NOT NULL,
    genre_id int NOT NULL,
    PRIMARY KEY (movie_id, genre_id),
    FOREIGN KEY (movie_id) REFERENCES movie (id),
    FOREIGN KEY (genre_id) REFERENCES genre (id)
);

-- Стоимость фильмов
CREATE TABLE IF NOT EXISTS movie_price
(
    id         SERIAL PRIMARY KEY,
    movie_id   integer     NOT NULL,
    price      integer     NOT NULL,
    type       varchar(60) NOT NULL,
    started_at date        NOT NULL,
    CONSTRAINT fk_movie
        FOREIGN KEY (movie_id)
            REFERENCES movie (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT movie_price_check CHECK (
        (
            (type) :: text = ANY (
                ARRAY [
                    ('first'::character varying)::text,
                    ('second'::character varying)::text,
                    ('third'::character varying)::text
                    ]
                )
            )
        )
);
COMMENT ON TABLE movie_price IS 'Цены фильмов';
COMMENT ON COLUMN movie_price.movie_id IS 'Ссылка на фильм';
COMMENT ON COLUMN movie_price.type IS 'Тип цены';
COMMENT ON COLUMN movie_price.started_at IS 'Дата начала действия цены';

-- Сидения
CREATE TABLE IF NOT EXISTS seat
(
    id      SERIAL PRIMARY KEY,
    number  int         NOT NULL,
    row     int         NOT NULL,
    hall_id int         NOT NULL,
    type    varchar(60) NOT NULL,
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES hall (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT seat_price_check CHECK (
        (
            (type) :: text = ANY (
                ARRAY [
                    ('first'::character varying)::text,
                    ('second'::character varying)::text,
                    ('third'::character varying)::text
                    ]
                )
            )
        )
);
COMMENT ON TABLE seat IS 'Сидения';
COMMENT ON COLUMN seat.number IS 'Номер сидения';
COMMENT ON COLUMN seat.row IS 'Ряд сидения';
COMMENT ON COLUMN seat.hall_id IS 'Ссылка на кинозал';

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

-- Билеты
CREATE TABLE IF NOT EXISTS ticket
(
    id         SERIAL PRIMARY KEY,
    seat_id    int  NOT NULL,
    session_id int  NOT NULL,
    is_sold    bool NOT NULL,
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

-- Продажи билетов
CREATE TABLE IF NOT EXISTS ticket_sale
(
    id             SERIAL PRIMARY KEY,
    ticket_id      int         NOT NULL,
    amount         int         NOT NULL,
    customer_email varchar(60) NOT NULL,
    created_at     date        NOT NULL DEFAULT CURRENT_DATE,
    CONSTRAINT fk_ticket
        FOREIGN KEY (ticket_id)
            REFERENCES ticket (id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
);
COMMENT ON TABLE ticket_sale IS 'Продажи билетов';
COMMENT ON COLUMN ticket_sale.ticket_id IS 'Ссылка на билет';
COMMENT ON COLUMN ticket_sale.amount IS 'Стоимость билета';
COMMENT ON COLUMN ticket_sale.customer_email IS 'Email покупателя';
