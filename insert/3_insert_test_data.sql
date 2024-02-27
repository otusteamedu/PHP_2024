-- Кинофильмы
INSERT INTO movie
    (name, description)
VALUES
    ('Best Movie 2007', 'Wow of wow'),
    ('Killers Of The Flower Moon', 'Scorseses vision and memorable execution of a complex, heart-breaking tale of lies and deception is bolstered by powerful performances from the three lead actors.'),
    ('The Wonderful Story Of Henry Sugar', 'Delightful testament to his directorial prowess'),
    ('Oppenheimer', 'Oppenheimer is a devastating biographical drama, one of his finest works.'),
    ('John Wick: Chapter 4', 'Redefines the gold standard for the action genre.'),
    ('Titanic', null),
    ('The Pigeon Tunnel', 'Essential viewing that offers a glimpse into the mind of the man responsible for some of the finest spy literature of the 20th century'),
    ('Barbie', 'Slathered with satire that is not sugar-coated');

-- Кинозалы
INSERT INTO room
    (name)
VALUES
    ('classic first'),
    ('classic second'),
    ('circle');

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
            (SELECT id FROM room WHERE name = 'circle'),
            (SELECT id FROM movie WHERE name = 'Best Movie 2007')
       ),
       (
            130,
            '2024-01-02 13:00:00',
            '2024-01-02 16:00:00',
            (SELECT id FROM room WHERE name = 'circle'),
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
            (SELECT id FROM room WHERE name = 'circle'),
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
            (SELECT id FROM room WHERE name = 'circle'),
            (SELECT id FROM movie WHERE name = 'John Wick: Chapter 4')
       ),
       (
            100,
            '2024-01-05 17:00:00',
            '2024-01-05 18:00:00',
            (SELECT id FROM room WHERE name = 'circle'),
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

    (null, 1, (SELECT id FROM room WHERE name = 'circle')),
    (null, 2, (SELECT id FROM room WHERE name = 'circle')),
    (null, 3, (SELECT id FROM room WHERE name = 'circle')),
    (null, 4, (SELECT id FROM room WHERE name = 'circle'));

-- Билеты
INSERT INTO ticket
    (owner, place_id, session_id)
VALUES
    (
        'Pavel Ananin',
        (
            SELECT place.id
            FROM place
            INNER JOIN room
                ON room.id = place.room_id
            WHERE room.name = 'classic first' AND place.horizontal = 1 AND place.vertical = 1
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
        (
            SELECT place.id
            FROM place
            INNER JOIN room
                ON room.id = place.room_id
            WHERE room.name = 'classic second' AND place.horizontal = 1 AND place.vertical = 2
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
        'Vasya Leo',
        (
            SELECT place.id
            FROM place
            INNER JOIN room
                ON room.id = place.room_id
            WHERE room.name = 'classic first' AND place.horizontal = 2 AND place.vertical = 2
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
        (
            SELECT place.id
            FROM place
            INNER JOIN room
                ON room.id = place.room_id
            WHERE room.name = 'classic first' AND place.horizontal = 2 AND place.vertical = 2
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
    );

