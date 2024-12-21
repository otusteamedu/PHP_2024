-- Проверка существует ли таблица halls и её удаление
DROP TABLE IF EXISTS public.halls CASCADE;
-- Создание таблицы halls (Кинозалы)
CREATE TABLE public.halls
(
    "id"         BIGSERIAL    NOT NULL PRIMARY KEY,
    "name"       VARCHAR(100) NOT NULL,
    "seat_count" INT          NOT NULL
);

-- Проверка существует ли таблица seats и её удаление
DROP TABLE IF EXISTS public.seats CASCADE;
-- Создание таблицы seats (Места в кинозале) + связь с таблицей (halls)
CREATE TABLE public.seats
(
    "id"      BIGSERIAL NOT NULL primary key,
    "hall_id" BIGINT    NOT NULL,
    "number"  INT       NOT NULL,
    "row"     INT       NOT NULL,

    CONSTRAINT public_seats_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Проверка существует ли таблица genres и её удаление
DROP TABLE IF EXISTS public.genres CASCADE;
-- Создание таблицы genres (Жанры фильмов)
CREATE TABLE public.genres
(
    "id"   BIGSERIAL    NOT NULL primary key,
    "name" VARCHAR(100) NOT NULL
);

-- Проверка существует ли таблица movies и её удаление
DROP TABLE IF EXISTS public.movies CASCADE;
-- Создание таблицы movies (Фильмы) + связь с таблицей genres
CREATE TABLE public.movies
(
    "id"          BIGSERIAL     NOT NULL primary key,
    "genre_id"    BIGINT        NOT NULL,
    "name"        VARCHAR(100)  NOT NULL,
    "description" VARCHAR(255)  NOT NULL,
    "duration"    INT           NOT NULL,
    "age_limit"   INT           NOT NULL,
    "rating"      decimal(2, 1) NOT NULL,

    CONSTRAINT public_movies_genre_id_foreign FOREIGN KEY (genre_id) REFERENCES genres (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля genre_id в таблице movies
CREATE INDEX public_movies_genre_id_index on movies ("genre_id");

-- Проверка существует ли таблица sessions и её удаление
DROP TABLE IF EXISTS public.sessions CASCADE;
-- Создание таблицы sessions (Сеансы) + связь с таблицами (halls, movies)
CREATE TABLE public.sessions
(
    "id"         BIGSERIAL NOT NULL primary key,
    "hall_id"    BIGINT    NOT NULL,
    "movie_id"  BIGINT    NOT NULL,
    "started_at" TIMESTAMP NOT NULL,
    "ended_at"   TIMESTAMP NOT NULL,

    CONSTRAINT public_sessions_hall_id_foreign FOREIGN KEY (hall_id) REFERENCES halls (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT public_sessions_movie_id_foreign FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля hall_id в таблице sessions
CREATE INDEX public_sessions_hall_id_index on sessions ("hall_id");
-- Создание индекса для поля movies_id в таблице sessions
CREATE INDEX public_sessions_movie_id_index on sessions ("movie_id");

-- Проверка существует ли таблица clients и её удаление
DROP TABLE IF EXISTS public.clients CASCADE;
-- Создание таблицы clients (Клиенты)
CREATE TABLE public.clients
(
    "id"      BIGSERIAL    NOT NULL primary key,
    "surname" VARCHAR(255) NOT NULL,
    "name"    VARCHAR(255) NOT NULL,
    "email"   VARCHAR(255) NOT NULL,
    "phone"   VARCHAR(50)  NOT NULL,
    "age"     INT          NOT NULL
);

-- Проверка существует ли таблица prices и её удаление
DROP TABLE IF EXISTS public.prices CASCADE;
-- Создание таблицы prices (Цены) + связь с таблицами (sessions, seats)
CREATE TABLE public.prices
(
    "id"         BIGSERIAL     NOT NULL primary key,
    "session_id" BIGINT        NOT NULL,
    "seat_id"    BIGINT        NOT NULL,
    "price"      DECIMAL(5, 2) NOT NULL,

    CONSTRAINT public_prices_session_id_foreign FOREIGN KEY (session_id) REFERENCES sessions (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT public_prices_seat_id_foreign FOREIGN KEY (seat_id) REFERENCES seats (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля session_id в таблице prices
CREATE INDEX public_prices_session_id_index on prices ("session_id");
-- Создание индекса для поля seat_id в таблице prices
CREATE INDEX public_prices_seat_id_index on prices ("seat_id");

-- Проверка существует ли таблица tickets и её удаление
DROP TABLE IF EXISTS public.tickets CASCADE;
-- Создание таблицы tickets (Билеты) + связь с таблицами (clients, prices)
CREATE TABLE public.tickets
(
    "id"        BIGSERIAL NOT NULL primary key,
    "client_id" BIGINT    NOT NULL,
    "price_id"  BIGINT    NOT NULL,
    "price"      DECIMAL(5, 2) NOT NULL,

    CONSTRAINT public_tickets_client_id_foreign FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT public_tickets_price_id_foreign FOREIGN KEY (price_id) REFERENCES prices (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Создание индекса для поля client_id в таблице tickets
CREATE INDEX public_tickets_client_id_index on tickets ("client_id");
-- Создание индекса для поля price_id в таблице tickets
CREATE INDEX public_tickets_price_id_index on tickets ("price_id");
