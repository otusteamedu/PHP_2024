-- Кинофильм
CREATE TABLE movie
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE,
    description VARCHAR(4096) NULL
);

-- Кинозал
CREATE TABLE room
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NULL UNIQUE
);

-- Киносессии
---- Намеренно не использован тип MONEY для PRICE, т.к. он занимает вдвое больше места
CREATE TABLE session
(
    id SERIAL PRIMARY KEY,
    price SMALLINT NOT NULL,
    begin TIMESTAMP NOT NULL,
    finish TIMESTAMP NOT NULL,
    room_id INTEGER REFERENCES room(id),
    movie_id INTEGER REFERENCES movie(id),

    unique(begin, room_id)
);

-- Посадочные места
----Здесь используются ключи VERTICAL и HORIZONTAL, потому что column - зарезервированное слово, а аналогов я не знаю
CREATE TABLE place
(
    id SERIAL PRIMARY KEY,
    horizontal SMALLINT NULL,
    vertical SMALLINT NULL,
    room_id INTEGER REFERENCES room(id),

    unique(horizontal, vertical, room_id)
);

--Билеты
CREATE TABLE ticket
(
    id SERIAL PRIMARY KEY,
    owner VARCHAR(128) NULL,
    place_id INTEGER REFERENCES place(id),
    session_id INTEGER REFERENCES session(id),

    unique(place_id, session_id)
);
