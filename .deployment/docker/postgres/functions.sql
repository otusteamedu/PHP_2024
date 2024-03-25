CREATE OR REPLACE FUNCTION random_between(low INT, high INT)
    RETURNS INT AS
$$
BEGIN
    RETURN floor(random() * (high - low + 1) + low);
END;
$$ language 'plpgsql' STRICT;


CREATE OR REPLACE FUNCTION fill_cinema_halls() RETURNS VOID AS
$$
DECLARE
    h RECORD;
BEGIN
    FOR h IN SELECT * FROM hall
        LOOP
            RAISE NOTICE 'Обрабатывается зал: %', h.name;

            INSERT INTO seat (number, row, hall_id, type)
            SELECT seat_num AS seat_num,
                   CEILING(s.seat_num::NUMERIC / (h.capacity / h.rows_count)) AS row_number,
                   h.id,
                   CASE
                       WHEN s.seat_num <= h.capacity * 0.2 THEN 'third'
                       WHEN s.seat_num <= h.capacity * 0.5 THEN 'second'
                       ELSE 'first'
                       END                                                    AS seat_type
            FROM generate_series(1, h.capacity) AS s(seat_num);
        END LOOP;
END;
$$ language 'plpgsql' STRICT;
