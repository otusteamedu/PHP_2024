INSERT INTO halls (name) VALUES ('hall1');

INSERT INTO ticket_type (type, discount) VALUES ('default', 0);

INSERT INTO row (hall_id) VALUES (1), (1), (1), (1), (1);

INSERT INTO session_prices (price) VALUES (150.00), (200.00), (250.00);

INSERT INTO movie (name)
SELECT 'movie' || uid::TEXT
FROM generate_series(1,10000) AS uid;


INSERT INTO "user" (name, last_name, email)
SELECT 'Иван', 'Иванов', 'mail' || uid::TEXT || '@mail.com'
FROM generate_series(1,10000) AS uid;

INSERT INTO seat (row_id, ticket_type)
SELECT floor(random()*(5)+1), 1
FROM generate_series(1,50) AS uid;


INSERT INTO "sessions" (hall_id, movie_id, price_id)
SELECT 1, floor(random()*(3)+1), floor(random()*(3)+1)
FROM generate_series(1,10000);

INSERT INTO "order" (user_id, session_id, seat_id)
SELECT floor(random()*(10000)+1), floor(random()*(10000)+1), floor(random()*(50)+1)
FROM generate_series(1,30000) AS uid;