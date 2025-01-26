TRUNCATE movie RESTART IDENTITY CASCADE;
TRUNCATE theater RESTART IDENTITY CASCADE;
TRUNCATE hall RESTART IDENTITY CASCADE;
TRUNCATE seat RESTART IDENTITY CASCADE;
TRUNCATE session RESTART IDENTITY CASCADE;
TRUNCATE price RESTART IDENTITY CASCADE;
TRUNCATE ticket RESTART IDENTITY CASCADE;

INSERT INTO movie(id, title, release_date, duration, description, rating)
SELECT gs.id,
       random_string((1 + random() * 29):: integer),
       random_date('2024-01-01', '2025-12-31'),
       random_between(100, 200),
       random_string((1 + random() * 500):: integer),
       random_string((1 + random() * 10):: integer)
FROM generate_series(1, 10000) as gs(id);

INSERT INTO theater(id, name, address)
SELECT gs.id,
       random_string((1 + random() * 29):: integer),
       random_string((1 + random() * 200):: integer)
FROM generate_series(1, 10) as gs(id);

DO
$$
BEGIN
FOR t IN 1..10 LOOP FOR c IN 1..5 LOOP
INSERT INTO
	hall(theater_id, name, capacity)
VALUES
	(
		t,
		random_string((1 + random()*29)::integer),
		random_between(50, 100)
    );
END LOOP;
END LOOP;
END;
$$;

DO
$$
BEGIN
FOR h IN 1..50 LOOP FOR r IN 1..10 LOOP FOR c IN 1..10 LOOP
INSERT INTO
	seat(hall_id, row_number, col_number, seat_type_id)
VALUES
	(
		h,
		r,
		c,
		random_between(1, 4)
    );
END LOOP;
END LOOP;
END LOOP;
END;
$$;

INSERT INTO session(id, movie_id, hall_id, start_time, end_time)
SELECT gs.id,
       random_between(1, 10000),
       random_between(1, 50),
       random_timestamp('2024-01-01', '2025-12-31'),
       random_timestamp('2024-01-01', '2025-12-31') + interval '2 hours'
FROM generate_series(1, 10000) as gs(id);

INSERT INTO price(id, session_id, seat_type_id, price)
SELECT gs.id,
       random_between(1, 10000),
       random_between(1, 4),
       round((random() * 1000):: numeric, 2)
FROM generate_series(1, 10000) as gs(id);

INSERT INTO ticket(id, session_id, seat_id, price, sold_at)
SELECT gs.id,
       random_between(1, 10000),
       random_between(1, 5000),
       round((random() * 1000):: numeric, 2),
       random_timestamp('2024-01-01', '2025-12-31')
FROM generate_series(1, 10000) as gs(id);
