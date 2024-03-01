-- Кинофильм
CREATE TABLE movie
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE,
    description VARCHAR(4096) NULL,
    release TIMESTAMP NULL,
    country VARCHAR(128) NULL
);

-- Жанр
CREATE TABLE genre
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL UNIQUE
);

-- Таблица связей кино-жанры
CREATE TABLE movie_genre
(
    genre_id INTEGER REFERENCES genre(id),
    movie_id INTEGER REFERENCES movie(id),

    PRIMARY KEY (genre_id, movie_id)
);


-- Кинозал
CREATE TABLE room
(
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NULL UNIQUE
);

-- Киносессии
CREATE TABLE session
(
    id SERIAL PRIMARY KEY,
    price MONEY NOT NULL,
    begin TIMESTAMP NOT NULL,
    finish TIMESTAMP NOT NULL,
    room_id INTEGER REFERENCES room(id),
    movie_id INTEGER REFERENCES movie(id),

    UNIQUE (begin, room_id)
);

-- Посадочные места
----Здесь используются ключи VERTICAL и HORIZONTAL, потому что column - зарезервированное слово, а аналогов я не знаю
CREATE TABLE place
(
    horizontal INTEGER NOT NULL,
    vertical INTEGER NOT NULL,
    room_id INTEGER REFERENCES room(id),

    PRIMARY KEY (horizontal, vertical, room_id)
);

--Билеты
CREATE TABLE ticket
(
    id SERIAL PRIMARY KEY,
    owner VARCHAR(128) NULL,
    session_id INTEGER REFERENCES session(id),
    place_horizontal INTEGER,
    place_vertical INTEGER,
    place_room_id INTEGER,

    FOREIGN KEY (place_horizontal, place_vertical, place_room_id) REFERENCES place (horizontal, vertical, room_id),
    UNIQUE (place_horizontal, place_vertical, place_room_id, session_id)
);
