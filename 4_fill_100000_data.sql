INSERT INTO timetable (movie_id, showtime)
SELECT (random() * 3)::integer + 1 AS movie_id,
       NOW() + (random() * INTERVAL '30 days') AS showtime
FROM generate_series(1, 100000) AS gs(id);

INSERT INTO tickets (timetable_id, seat_id, price)
SELECT (random() * 9999)::integer + 1 AS timetable_id,
       (random() * 499)::integer + 1 AS seat_id,
       round((random() * 15 + 5)::numeric, 2) AS price
FROM generate_series(1, 100000) AS gs(id);


INSERT INTO movies (name, release_date, duration)
SELECT CONCAT('random_name_', round(random()*100000)) AS name,
       (NOW() + (random() * INTERVAL '30 days'))::date AS release_date,
       round((random()*100)) AS duration
FROM generate_series(1, 100000) AS gs(id);