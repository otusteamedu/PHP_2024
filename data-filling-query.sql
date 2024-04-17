/* Наполнение данных */

INSERT INTO films (film) VALUES ('Тупой и еще тупее'),('Люди в черном'),('Люди в черном 2'),('Афоня'),('Назад в будущее'),('Назад в будущее 2');

INSERT INTO halls (name) VALUES ('Зал 1'),('Зал 2'),('Зал 3');

INSERT INTO seats (hall_id, line, number)
SELECT
    id, seat_line, seat_number
FROM
    unnest(string_to_array('A1,A2,A3,A4,A5,A6,A7,A8,A9,A10,B1,B2,B3,B4,B5,B6,B7,B8,B9,B10,C1,C2,C3,C4,C5,C6,C7,C8,C9,C10', ',')) as seat_number,
    unnest(string_to_array('1,2,3', ',')) as seat_line,
    halls;

INSERT INTO sessions (hall_id,session_at,film_id)
SELECT
    hall_id,session_at,ANY_VALUE(film_id) film_id
FROM (
         SELECT
             halls.id hall_id,TO_TIMESTAMP(session_at, 'YYYY-MM-DD HH24:MI:ss') session_at,films.id film_id
         FROM
             unnest(
                     string_to_array(
                             concat(
                                     concat(current_date, ' ', '12:00:00'),',',
                                     concat(current_date, ' ', '22:00:00'),',',
                                     concat(current_date, ' ', '12:00:00'),',',
                                     concat(current_date, ' ', '18:00:00'),',',
                                     concat(current_date - interval '1 days', ' ', '12:00:00'),',',
                                     concat(current_date - interval '2 days', ' ', '22:00:00'),',',
                                     concat(current_date + interval '3 days', ' ', '12:00:00'),',',
                                     concat(current_date + interval '3 days', ' ', '18:00:00'),',',
                                     concat(current_date - interval '6 days', ' ', '12:00:00'),',',
                                     concat(current_date - interval '8 days', ' ', '22:00:00'),',',
                                     concat(current_date - interval '9 days', ' ', '12:00:00'),',',
                                     concat(current_date - interval '9 days', ' ', '18:00:00'),',',
                                     concat(current_date + interval '1 days', ' ', '12:00:00'),',',
                                     concat(current_date + interval '2 days', ' ', '22:00:00'),',',
                                     concat(current_date + interval '5 days', ' ', '12:00:00'),',',
                                     concat(current_date + interval '4 days', ' ', '18:00:00'),',',
                                     concat(current_date + interval '4 days', ' ', '20:00:00'),',',
                                     concat(current_date + interval '5 days', ' ', '22:00:00')
                             ),
                             ','
                     )
             ) as session_at,
             halls,
             films
         order by random()
     ) AS t
GROUP BY hall_id,session_at;

CREATE OR REPLACE FUNCTION random_between(low INT ,high INT)
    RETURNS INT AS
$$
BEGIN
RETURN floor(random()* (high-low + 1) + low);
END;
$$ language 'plpgsql' STRICT;

DO $$
    DECLARE rec RECORD;
BEGIN FOR rec IN
SELECT sessions.id session_id,s.hall_id,s.id seat_id,random_between(150, 1000) price FROM sessions INNER JOIN seats s on sessions.hall_id = s.hall_id
    LOOP
INSERT INTO booking_session_seats (session_id, hall_id, seat_id, price) VALUES (rec.session_id, rec.hall_id, rec.seat_id,rec.price);
END LOOP;
END;
$$;

UPDATE booking_session_seats SET is_reserved = true WHERE id IN (
    SELECT DISTINCT random_between(1, CAST(t.max_id AS INTEGER)) id
    FROM booking_session_seats,
         (SELECT MAX(id) max_id FROM booking_session_seats) t
);