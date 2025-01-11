INSERT INTO halls("number", "seats_count")
SELECT
    gs.id,
    100 + random() * 100
FROM generate_series(1, 10000000) as gs(id);

INSERT INTO movies("name")
SELECT
    random_string((1 + random() * 30)::integer)
FROM generate_series(1, 10000000) as gs(id);

INSERT INTO sessions("movie_id", "hall_id", "date", "begin_time", "duration")
SELECT
    100 + random() * 10000000,
    100 + random() * 10000000,
    (now()::date - (random() * 365)::int)::date,
    date_trunc('minute',('09:00'::time + (random() * ('22:00'::time - '09:00'::time)))::time),
    90 + random() * 100
FROM generate_series(1, 10000000) as gs(id);

INSERT INTO tickets("session_id", "price", "seat_number", "is_sold")
SELECT
    100 + random() * 10000000,
    (100 + random() * (1000 - 100))::numeric(10, 2),
    1 + random() * 200,
    random() < 0.4
FROM generate_series(1, 10000000) as gs(id);