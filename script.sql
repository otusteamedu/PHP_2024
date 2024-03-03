/* Структура базы */

CREATE TABLE halls (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       UNIQUE (name)
);

CREATE TABLE seats (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       hall_id BIGINT NOT NULL,
                       number VARCHAR(100) NOT NULL,
                       CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                       UNIQUE (hall_id, number)
);

CREATE TABLE films (
                       id BIGSERIAL NOT NULL PRIMARY KEY,
                       film VARCHAR(100) NOT NULL,
                       UNIQUE (film)
);

CREATE TABLE session (
                         id BIGSERIAL NOT NULL PRIMARY KEY,
                         hall_id BIGINT NOT NULL,
                         film_id BIGINT NOT NULL,
                         session_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                         CONSTRAINT fk_film FOREIGN KEY (film_id) REFERENCES films(id),
                         UNIQUE (hall_id,session_at)
);

CREATE TABLE booking_session_seats (
                                       id BIGSERIAL NOT NULL PRIMARY KEY,
                                       session_id BIGINT NOT NULL,
                                       hall_id BIGINT NOT NULL,
                                       seat_id BIGINT NOT NULL,
                                       price DECIMAL(10,2),
                                       is_reserved BOOLEAN NOT NULL DEFAULT FALSE,
                                       CONSTRAINT fk_session FOREIGN KEY (session_id) REFERENCES session(id),
                                       CONSTRAINT fk_hall FOREIGN KEY (hall_id) REFERENCES halls(id),
                                       CONSTRAINT fk_seat FOREIGN KEY (seat_id) REFERENCES seats(id),
                                       UNIQUE (session_id, hall_id, seat_id)
);









/* Наполнение данных */

INSERT INTO films (film) VALUES ('Тупой и еще тупее'),('Люди в черном'),('Люди в черном 2'),('Афоня'),('Назад в будущее'),('Назад в будущее 2');

INSERT INTO halls (name) VALUES ('Зал 1'),('Зал 2'),('Зал 3');

INSERT INTO seats (hall_id, number)
SELECT
    id,seat_number
FROM
    unnest(string_to_array('A1,A2,A3,A4,A5,A6,A7,A8,A9,A10,B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10', ',')) as seat_number,
    halls;

INSERT INTO session (hall_id,session_at,film_id)
SELECT
    hall_id,session_at,ANY_VALUE(film_id) film_id
FROM (
         SELECT
             halls.id hall_id,TO_TIMESTAMP(session_at, 'YYYY-MM-DD HH24:MI:ss') session_at,films.id film_id
         FROM
             unnest(string_to_array('2024-03-03 12:00:00,2024-03-03 16:00:00,2024-03-03 18:00:00', ',')) as session_at,
             halls,
             films
         order by random()
     ) AS t
GROUP BY hall_id,session_at;

DO $$
    DECLARE rec RECORD;
BEGIN FOR rec IN
SELECT session.id session_id,s.hall_id,s.id seat_id,280 price FROM session INNER JOIN seats s on session.hall_id = s.hall_id
    LOOP
INSERT INTO booking_session_seats (session_id, hall_id, seat_id, price) VALUES (rec.session_id, rec.hall_id, rec.seat_id,rec.price);
END LOOP;
END;
$$;

CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;

UPDATE booking_session_seats SET is_reserved = true WHERE id IN (
    SELECT DISTINCT random_between(1, CAST(t.max_id AS INTEGER)) id
    FROM booking_session_seats,
         (SELECT MAX(id) max_id FROM booking_session_seats) t
);






/* Запрос нахождения самого прибыльного фильма  */
SELECT f.film, SUM(b.price)
FROM booking_session_seats b
         inner join session s on b.session_id = s.id
         inner join films f on s.film_id = f.id
WHERE is_reserved = true
GROUP BY f.film
ORDER BY SUM(b.price) DESC LIMIT 1;
