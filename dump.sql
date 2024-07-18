INSERT INTO movies (name)
VALUES ('Alexandros in the woods'),
       ('Need for Speed: Meth Addict');

INSERT INTO movie_attribute_types (name)
VALUES ('Review'),
       ('Award'),
       ('Important Dates'),
       ('Service Dates'),
       ('Rating');

INSERT INTO movie_attributes (name, movie_attribute_type_id)
VALUES ('Critic Review', 1),
       ('Unknown Academy Review', 1),
       ('Oscar', 2),
       ('Nika', 2),
       ('World Premiere', 3),
       ('Premiere in Russia', 3),
       ('Ticket Sales Start Date', 4),
       ('TV Ad Launch Date', 4),
       ('IMDB Rating', 5),
       ('Critic Rating', 5);

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, text)
VALUES (1, 1, 'An iconic sci-fi film.'),
       (1, 2, 'Highly recommended by the group of teenagers.'),
       (2, 1, 'A worthy sequel to the original.'),
       (2, 2, 'Received mixed reviews from the IMDB.');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, boolean)
VALUES (1, 3, TRUE),
       (2, 3, FALSE),
       (1, 4, FALSE),
       (2, 4, TRUE);

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, date)
VALUES (1, 5, '2024-07-20'),
       (2, 5, '2024-07-30');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, timestamp)
VALUES (1, 6, '2024-07-23 00:00:00'),
       (2, 6, '2024-08-02 00:00:00');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, date)
VALUES (1, 7, '2024-07-20'),
       (2, 7, '2024-08-01');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, timestamp)
VALUES (1, 8, '2024-07-18 00:00:00'),
       (2, 8, '2024-07-18 00:00:00');

INSERT INTO movie_attribute_value (movie_id, movie_attribute_id, numeric)
VALUES (1, 9, 8.1),
       (2, 9, 8.5),
       (1, 10, 7.9),
       (2, 10, 8.4);

CREATE VIEW service_data AS
SELECT m.name AS movie,
       a.name AS task,
       COALESCE(
               v.date::TEXT,
               v.timestamp::TEXT
       )      AS value
FROM movies m
         JOIN movie_attribute_value v ON m.id = v.movie_id
         JOIN movie_attributes a ON v.movie_attribute_id = a.id
         JOIN movie_attribute_types at ON a.movie_attribute_type_id = at.id
WHERE at.name = 'Service Dates'
  AND (
    v.date = CURRENT_DATE
        OR v.timestamp::date = CURRENT_DATE
        OR v.date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '20 days'
        OR v.timestamp::date BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL '20 days'
    );

CREATE VIEW marketing_data AS
SELECT m.name  AS movie,
       at.name AS attribute_type,
       a.name  AS attribute,
       COALESCE(
               v.text::TEXT,
               v.boolean::TEXT,
               v.date::TEXT,
               v.timestamp::TEXT,
               v.numeric::TEXT
       )       AS value
FROM movies m
         JOIN movie_attribute_value v ON m.id = v.movie_id
         JOIN movie_attributes a ON v.movie_attribute_id = a.id
         JOIN movie_attribute_types at ON a.movie_attribute_type_id = at.id;
