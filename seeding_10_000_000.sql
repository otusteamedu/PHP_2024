TRUNCATE cinema_halls restart identity cascade
;

TRUNCATE movies restart identity cascade
;

TRUNCATE shows restart identity cascade
;

TRUNCATE seats restart identity cascade
;

TRUNCATE prices restart identity cascade
;

TRUNCATE tickets restart identity cascade
;

TRUNCATE sales restart identity cascade
;

INSERT INTO
	cinema_halls (name)
SELECT
	random_string ((1 + random() * 29)::integer)
FROM
	generate_series(1, 10)
;

INSERT INTO
	movies ("name", "from", "to")
SELECT
	random_string ((1 + random() * 29)::integer),
	random_date (num % 10),
	random_date (num % 10) + interval '14 days'
FROM
	generate_series(1, 500) AS num
;

INSERT INTO
	shows (movie_id, cinema_hall_id, "from", "to")
SELECT
	random_between (1, 500),
	random_between (1, 10),
	random_date (num % 10),
	random_date (num % 10) + interval '2 hours'
FROM
	generate_series(1, 500000) AS num
;

DO $$ begin for c in 1..10 loop for r in 1..20 loop for n in 1..30 loop
insert into
	seats (cinema_hall_id, row, number, type)
values
	(
		c,
		r,
		n,
		(ARRAY [ 'first', 'second', 'third' ]) [FLOOR(
      RANDOM() * 3 + 1
    ) ]
	);

end loop;

end loop;

end loop;

end;

$$
;

INSERT INTO
	prices (date_from, movie_id, "type", price)
SELECT
	random_date (num),
	random_between (1, 500),
	(ARRAY['first', 'second', 'third']) [floor(random() * 3 + 1)],
	round((random() * 1000)::numeric, 2)
FROM
	generate_series(1, 10000) AS num
;

INSERT INTO
	tickets (show_id, seat_id, is_sold)
SELECT
	random_between (1, 500000),
	trunc(random() * (10 * 20 * 30) + 1),
	random() < 0.7
FROM
	generate_series(1, 6000000) AS num
;

INSERT INTO
	sales (date, amount, ticket_id)
SELECT
	random_date ((random() * 100)::integer),
	round((random() * 1000)::numeric, 2),
	random_between (1, 5000000)
FROM
	generate_series(1, 3500000) AS num
;