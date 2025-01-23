DROP TABLE IF EXISTS movie_directors CASCADE;
DROP TABLE IF EXISTS movies CASCADE;

CREATE TABLE movie_directors
(
    id            SERIAL PRIMARY KEY,
    name          varchar(255) NOT NULL,
    orig_name     varchar(255) NOT NULL,
    date_of_birth DATE         NOT NULL
);

CREATE TABLE IF NOT EXISTS movies
(
    id                SERIAL PRIMARY KEY,
    title             VARCHAR(255) NOT NULL,
    orig_title        VARCHAR(255) NOT NULL,
    genre             VARCHAR(255),
    year              INT,
    duration          INT,
    rating            FLOAT,
    movie_director_id INT,
    FOREIGN KEY (movie_director_id) REFERENCES movie_directors (id)
);

CREATE INDEX idx_movies_rating ON movies (rating);


-- Tables Data
INSERT INTO movie_directors (name, orig_name, date_of_birth)
VALUES ('Квентин Тарантино', 'Quentin Tarantino', '1963-03-27'),
       ('Ларс фон Триер', 'Lars von Trier', '1956-04-30'),
       ('Мартин Скорсезе', 'Martin Scorsese', '1942-11-17'),
       ('Фрэнсис Форд Коппола', 'Francis Ford Coppola', '1939-04-07')

INSERT INTO movies (title, orig_title, genre, year, duration, rating, movie_director_id)
VALUES ('Однажды в… Голливуде', 'Once Upon a Time in... Hollywood', 'драма, комедия', '2019', '161', '7.7', 1),
       ('Омерзительная восьмерка', 'The Hateful Eight', 'вестерн, криминал, триллер, драма, детектив', '2015', '168',
        '8.0', 1),
       ('Джанго освобожденный', 'Django Unchained', 'вестерн, боевик, драма, комедия', '2012', '165', '8.7', 1),
       ('Бесславные ублюдки', 'Inglourious Basterds', 'боевик, драма, комедия, военный', '2009', '153', '8.0', 1),

       ('Дом, который построил Джек', 'The House That Jack Built', 'триллер, драма, криминал, ужасы', '2018', '152',
        '7.0', 2),
       ('Меланхолия', 'Melancholia', 'фантастика, драма', '2011', '130', '7.0', 2),
       ('Догвилль', 'Dogville', 'криминал, драма, биография', '2003', '178', '8.0', 2),
       ('Танцующая в темноте', 'Dancer in the Dark', 'мюзикл, драма, криминал', '2000', '140', '8.0', 2),

       ('Убийцы цветочной луны', 'Killers of the Flower Moon', 'драма, криминал, история', '2023', '206', '7.2', 3),
       ('Ирландец', 'The Irishman', 'криминал, драма, биография', '2019', '209', '7.4', 3),
       ('Волк с Уолл-стрит', 'The Wolf of Wall Street', 'драма, криминал, биография, комедия', '2013', '180', '8.0', 3),
       ('Остров проклятых', 'Shutter Island', 'триллер, детектив, драма', '2009', '138', '8.5', 3),

       ('Крестный отец 3', 'The Godfather: Part III', 'криминал, драма', '1990', '170', '7.9', 4),
       ('Апокалипсис сегодня', 'Apocalypse Now', 'военный, драма, история, боевик', '1979', '94', '8.1', 4),
       ('Крестный отец 2', 'The Godfather: Part II', 'драма, криминал', '1974', '202', '8.5', 4),
       ('Крестный отец', 'The Godfather', 'драма, криминал', '1972', '175', '8.7', 4)