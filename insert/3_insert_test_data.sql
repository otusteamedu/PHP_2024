-- Кинофильмы
INSERT INTO movie
    (name, description, release, country)
VALUES
    ('Best Movie 2007', 'Wow of wow', '2014-01-02 00:00:00', 'Russia'),
    ('Killers Of The Flower Moon', 'Scorseses vision and memorable execution of a complex, heart-breaking tale of lies and deception is bolstered by powerful performances from the three lead actors.', '2016-01-08 00:00:00', 'Germany'),
    ('The Wonderful Story Of Henry Sugar', 'Delightful testament to his directorial prowess', '2018-01-02 00:00:00', 'USA'),
    ('Oppenheimer', 'Oppenheimer is a devastating biographical drama, one of his finest works.', '2022-01-02 00:00:00', 'Russia'),
    ('John Wick: Chapter 4', 'Redefines the gold standard for the action genre.', '2018-01-02 00:00:00', 'Germany'),
    ('Titanic', null, '1999-01-02 00:00:00', 'USA'),
    ('The Pigeon Tunnel', 'Essential viewing that offers a glimpse into the mind of the man responsible for some of the finest spy literature of the 20th century', '2014-01-02 00:00:00', 'Russia'),
    ('Barbie', 'Slathered with satire that is not sugar-coated', '2018-01-02 00:00:00', 'USA');

-- Жанры
INSERT INTO genre
    (name)
VALUES
    ('comedy'),
    ('horror'),
    ('arthouse'),
    ('other');

-- Кино - жанры
INSERT INTO movie_genre
    (movie_id, genre_id)
VALUES
    ((SELECT id FROM movie WHERE name = 'Best Movie 2007'), (SELECT id FROM genre WHERE name = 'comedy')),
    ((SELECT id FROM movie WHERE name = 'Best Movie 2007'), (SELECT id FROM genre WHERE name = 'horror')),
    ((SELECT id FROM movie WHERE name = 'Best Movie 2007'), (SELECT id FROM genre WHERE name = 'arthouse')),
    ((SELECT id FROM movie WHERE name = 'Best Movie 2007'), (SELECT id FROM genre WHERE name = 'other')),
    ((SELECT id FROM movie WHERE name = 'Oppenheimer'), (SELECT id FROM genre WHERE name = 'arthouse')),
    ((SELECT id FROM movie WHERE name = 'Oppenheimer'), (SELECT id FROM genre WHERE name = 'other')),
    ((SELECT id FROM movie WHERE name = 'Titanic'), (SELECT id FROM genre WHERE name = 'other')),
    ((SELECT id FROM movie WHERE name = 'Titanic'), (SELECT id FROM genre WHERE name = 'horror')),
    ((SELECT id FROM movie WHERE name = 'Titanic'), (SELECT id FROM genre WHERE name = 'arthouse')),
    ((SELECT id FROM movie WHERE name = 'The Wonderful Story Of Henry Sugar'), (SELECT id FROM genre WHERE name = 'comedy')),
    ((SELECT id FROM movie WHERE name = 'The Wonderful Story Of Henry Sugar'), (SELECT id FROM genre WHERE name = 'horror')),
    ((SELECT id FROM movie WHERE name = 'Barbie'), (SELECT id FROM genre WHERE name = 'arthouse')),
    ((SELECT id FROM movie WHERE name = 'Barbie'), (SELECT id FROM genre WHERE name = 'other'));

-- Кинозалы
INSERT INTO room
    (name)
VALUES
    ('classic first'),
    ('classic second'),
    ('vip'),
    ('romantic');

-- Киносессии
INSERT INTO session
    (price, begin, finish, room_id, movie_id)
VALUES (
            250,
            '2024-01-01 10:30:00',
            '2024-01-01 12:30:00',
            (SELECT id FROM room WHERE name = 'classic first'),
            (SELECT id FROM movie WHERE name = 'Titanic')
       ),
       (
            150,
            '2024-01-01 14:30:00',
            '2024-01-01 15:30:00',
            (SELECT id FROM room WHERE name = 'classic second'),
            (SELECT id FROM movie WHERE name = 'Barbie')
       ),
       (
            550,
            '2024-01-02 10:00:00',
            '2024-01-02 12:00:00',
            (SELECT id FROM room WHERE name = 'classic first'),
            (SELECT id FROM movie WHERE name = 'Oppenheimer')
       ),
       (
            180,
            '2024-01-02 13:00:00',
            '2024-01-02 16:00:00',
            (SELECT id FROM room WHERE name = 'romantic'),
            (SELECT id FROM movie WHERE name = 'Best Movie 2007')
       ),
       (
            130,
            '2024-01-02 13:00:00',
            '2024-01-02 16:00:00',
            (SELECT id FROM room WHERE name = 'classic second'),
            (SELECT id FROM movie WHERE name = 'Best Movie 2007')
       ),
       (
            280,
            '2024-01-02 14:00:00',
            '2024-01-02 16:00:00',
            (SELECT id FROM room WHERE name = 'classic first'),
            (SELECT id FROM movie WHERE name = 'Killers Of The Flower Moon')
       ),
       (
            380,
            '2024-01-03 13:00:00',
            '2024-01-03 16:00:00',
            (SELECT id FROM room WHERE name = 'romantic'),
            (SELECT id FROM movie WHERE name = 'The Wonderful Story Of Henry Sugar')
       ),
       (
            480,
            '2024-01-04 13:00:00',
            '2024-01-04 16:00:00',
            (SELECT id FROM room WHERE name = 'classic second'),
            (SELECT id FROM movie WHERE name = 'Oppenheimer')
       ),
       (
            200,
            '2024-01-05 13:00:00',
            '2024-01-05 16:00:00',
            (SELECT id FROM room WHERE name = 'romantic'),
            (SELECT id FROM movie WHERE name = 'John Wick: Chapter 4')
       ),
       (
            100,
            '2024-01-05 17:00:00',
            '2024-01-05 18:00:00',
            (SELECT id FROM room WHERE name = 'romantic'),
            (SELECT id FROM movie WHERE name = 'Titanic')
       ),
       (
            100,
            '2024-01-05 17:00:00',
            '2024-01-05 18:00:00',
            (SELECT id FROM room WHERE name = 'classic second'),
            (SELECT id FROM movie WHERE name = 'The Pigeon Tunnel')
       );

-- Места в залах
INSERT INTO place
    (horizontal, vertical, room_id)
VALUES
    (1, 1, (SELECT id FROM room WHERE name = 'classic first')),
    (1, 2, (SELECT id FROM room WHERE name = 'classic first')),
    (1, 3, (SELECT id FROM room WHERE name = 'classic first')),
    (2, 1, (SELECT id FROM room WHERE name = 'classic first')),
    (2, 2, (SELECT id FROM room WHERE name = 'classic first')),
    (2, 3, (SELECT id FROM room WHERE name = 'classic first')),

    (1, 1, (SELECT id FROM room WHERE name = 'classic second')),
    (1, 2, (SELECT id FROM room WHERE name = 'classic second')),
    (2, 1, (SELECT id FROM room WHERE name = 'classic second')),
    (2, 2, (SELECT id FROM room WHERE name = 'classic second')),

    (1, 1, (SELECT id FROM room WHERE name = 'vip')),

    (1, 1, (SELECT id FROM room WHERE name = 'romantic')),
    (2, 1, (SELECT id FROM room WHERE name = 'romantic'));



-- Билеты
INSERT INTO ticket
    (owner, place_horizontal, place_vertical, place_room_id, session_id)
VALUES
    (
        'Pavel Ananin',
        1,
        1,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic first'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic first' AND movie.name = 'Titanic' AND session.begin = '2024-01-01 10:30:00'
        )
    ),
    (
        'Vitalik O.',
        1,
        2,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic second'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic second' AND movie.name = 'Barbie' AND session.begin = '2024-01-01 14:30:00'
        )
    ),
    (
        'Bazanov',
        2,
        2,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic first'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic first' AND movie.name = 'Titanic' AND session.begin = '2024-01-01 10:30:00'
        )
    ),
    (
        'Pavel Ananin',
        2,
        2,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic first'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic first' AND movie.name = 'Oppenheimer' AND session.begin = '2024-01-02 10:00:00'
        )
    ),
    (
        'Pavel Not Ananin',
        1,
        1,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic first'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic first' AND movie.name = 'Oppenheimer' AND session.begin = '2024-01-02 10:00:00'
        )
    ),
    (
        'Maria DB.',
        1,
        1,
        (
            SELECT id
            FROM room
            WHERE room.name = 'romantic'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'romantic' AND movie.name = 'John Wick: Chapter 4' AND session.begin = '2024-01-05 13:00:00'
        )
    ),
    (
        'Jorik',
        2,
        1,
        (
            SELECT id
            FROM room
            WHERE room.name = 'romantic'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'romantic' AND movie.name = 'John Wick: Chapter 4' AND session.begin = '2024-01-05 13:00:00'
        )
    ),
    (
        'Bazanov',
        1,
        1,
        (
            SELECT id
            FROM room
            WHERE room.name = 'classic first'
        ),
        (
            SELECT session.id
            FROM session
            INNER JOIN room
                ON room.id = session.room_id
            INNER JOIN movie
                ON movie.id = session.movie_id
            WHERE room.name = 'classic first' AND movie.name = 'Killers Of The Flower Moon' AND session.begin = '2024-01-02 14:00:00'
        )
    );

