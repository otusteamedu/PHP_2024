-- CREATE DATABASE otus_cinema ENCODING = 'UTF8';

-- подключаемся к otus_cinema

CREATE TABLE price_category (
	id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL
);

INSERT INTO price_category(title)
VALUES 
    ('низкая'),
    ('средняя'),
    ('высшая');

CREATE TABLE price_key (
    id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL
);    

INSERT INTO price_key(title)
VALUES 
    ('фильм'),
    ('зал'),
    ('место'),
    ('сеанс');

CREATE TABLE seat_location (
	id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL,
    price_category_id INTEGER REFERENCES price_category
);

INSERT INTO seat_location(title, price_category_id)
VALUES 
    ('партер', 1),
    ('галёрка', 2),
    ('центр', 3);

CREATE TABLE seat_scheme (
	id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    scheme JSON
);

INSERT INTO seat_scheme(title, scheme)
VALUES
    ('малый зал', 
	    '{
            "row_1":{"0":{"noSeat":true},"1":{"noSeat":true},"number_1":{"number":1,"row":1,"locationId":1},"number_2":{"number":2,"row":1,"locationId":1},"number_3":{"number":3,"row":1,"locationId":1},"number_4":{"number":4,"row":1,"locationId":1}},
            "row_2":{"0":{"noSeat":true},"1":{"noSeat":true},"number_1":{"number":1,"row":2,"locationId":3},"number_2":{"number":2,"row":2,"locationId":3},"number_3":{"number":3,"row":2,"locationId":3},"number_4":{"number":4,"row":2,"locationId":3}},
            "row_3":{"0":{"noSeat":true},"1":{"noSeat":true},"number_1":{"number":1,"row":3,"locationId":3},"number_2":{"number":2,"row":3,"locationId":3},"number_3":{"number":3,"row":3,"locationId":3},"number_4":{"number":4,"row":3,"locationId":3}},
            "row_4":{"number_1":{"number":1,"row":4,"locationId":2},"number_2":{"number":2,"row":4,"locationId":2},"number_3":{"number":3,"row":4,"locationId":2},"number_4":{"number":4,"row":4,"locationId":2},"number_5":{"number":4,"row":4,"locationId":2},"number_6":{"number":4,"row":4,"locationId":2}}
        }' 
    );  

CREATE TABLE hall (
	id SERIAL PRIMARY KEY,
	title VARCHAR(50) NOT NULL,
    max_seat SMALLINT NOT NULL,
    price_category_id INTEGER REFERENCES price_category,
    seat_scheme_id INTEGER REFERENCES seat_scheme
);

INSERT INTO hall(title, max_seat, price_category_id, seat_scheme_id)
VALUES 
    ('белый', 18, 1, 1),
    ('синий', 18, 2, 1),
    ('красный', 18, 3, 1);

CREATE TABLE movie (
	id SERIAL PRIMARY KEY,
	title VARCHAR(100),
    duration INTERVAL NOT NULL,
    min_price DECIMAL NOT NULL,
    price_category_id INTEGER REFERENCES price_category,
    session_from DATE,
    session_to DATE
);

INSERT INTO movie(title, duration, min_price, price_category_id, session_from, session_to)
VALUES 
    ('Гарри Поттер', '1h 31m 1s', 100, 1, '01.09.2024', '30.09.2024'),
    ('Пираты Карибского моря', '1h 32m 2s', 150, 2, '01.09.2024', '30.09.2024'),
    ('Последний киногерой', '1h 33m 3s', 200, 3, '01.09.2024', '30.09.2024');

CREATE INDEX  movie_title_idx ON movie (id, title);   
 
CREATE TABLE schedule (
    id SERIAL PRIMARY KEY,
    time_begin TIMESTAMP NOT NULL,
    time_end TIMESTAMP NOT NULL,
    movie_id INTEGER REFERENCES movie,
    hall_id INTEGER REFERENCES hall,
    price_category_id INTEGER REFERENCES price_category
);

INSERT INTO schedule(time_begin, time_end, movie_id, hall_id, price_category_id)
VALUES 
    ('2024-09-24 10:00', '2024-09-14 12:00', 1, 1, 1),
    ('2024-09-24 14:00', '2024-09-14 16:00', 1, 1, 2),
    ('2024-09-24 20:00', '2024-09-14 22:00', 1, 1, 3),
    ('2024-09-24 10:00', '2024-09-14 12:00', 2, 2, 1),
    ('2024-09-24 14:00', '2024-09-14 16:00', 2, 2, 2),
    ('2024-09-24 20:00', '2024-09-14 22:00', 2, 2, 3),
    ('2024-09-24 10:00', '2024-09-14 12:00', 3, 3, 1),
    ('2024-09-24 14:00', '2024-09-14 16:00', 3, 3, 2),
    ('2024-09-24 20:00', '2024-09-14 22:00', 3, 3, 3);

CREATE TABLE tariff (
    id SERIAL PRIMARY KEY,
    price_key_id INTEGER REFERENCES price_key,
    price_category_id INTEGER REFERENCES price_category,
    tariff_value DECIMAL NOT NULL
);

INSERT INTO tariff(price_key_id, price_category_id, tariff_value)
VALUES
    (1, 1, 0),
    (1, 2, 50),
    (1, 3, 100),
    (2, 1, 0),
    (2, 2, 50),
    (2, 3, 100),
    (3, 1, 0),
    (3, 2, 50),
    (3, 3, 100),
    (4, 1, 0),
    (4, 2, 50),
    (4, 3, 100);

CREATE TABLE ticket (
    id SERIAL PRIMARY KEY,
    schedule_id INTEGER REFERENCES schedule,
    seat_row SMALLINT,
    seat_number SMALLINT,
    tariff_price DECIMAL NOT NULL
);     

CREATE INDEX ticket_schedule_idx ON ticket (id, schedule_id);

-- определяем цену для каждого кресла/зала/фильма/сеанса и заливаем таблицу билетов

DO
$$

DECLARE
	_max_schedule integer := (SELECT COUNT(*) FROM schedule);
	_max_row integer := (SELECT COUNT(*) FROM (SELECT jsonb_each(scheme::jsonb) FROM seat_scheme));
	_max_seat integer := (SELECT COUNT(*) FROM (SELECT jsonb_each(scheme::jsonb -> 'row_1') FROM seat_scheme));
	
BEGIN
    FOR _i IN 1.._max_schedule LOOP
	FOR _r IN 1.._max_row LOOP
	FOR _s IN 1.._max_seat LOOP
	
	IF ((SELECT (scheme::jsonb -> ('row_' || _r)) -> ('number_' || _s) -> 'locationId' FROM seat_scheme) IS NOT NULL)
	
	THEN
		INSERT INTO ticket (schedule_id, seat_row, seat_number, tariff_price)
		SELECT schedule.id, _r, _s, (movie.min_price + tariff_movie.tariff_value + tariff_hall.tariff_value + tariff_seat.tariff_value + tariff_schedule.tariff_value) 
		FROM schedule schedule
		JOIN hall hall ON hall.id = schedule.hall_id
		JOIN movie movie ON movie.id = schedule.movie_id
		JOIN seat_scheme seat_scheme ON seat_scheme.id = hall.seat_scheme_id
		JOIN tariff tariff_movie ON tariff_movie.price_key_id = 1 
			AND tariff_movie.price_category_id = movie.price_category_id
		JOIN tariff tariff_hall ON tariff_hall.price_key_id = 2 
			AND tariff_hall.price_category_id = hall.price_category_id
		JOIN tariff tariff_seat ON tariff_seat.price_key_id = 3 
			AND tariff_seat.price_category_id = ((seat_scheme.scheme::jsonb -> ('row_' || _r)) -> ('number_' || _s) -> 'locationId')::INTEGER
		JOIN tariff tariff_schedule ON tariff_schedule.price_key_id = 4 
			AND tariff_schedule.price_category_id = schedule.price_category_id
		WHERE schedule.id = _i;
	END IF;
	
	END LOOP;
	END LOOP;
    END LOOP;
END;
$$; 

-- считаем выручку

SELECT movie.title, SUM(ticket.tariff_price) AS sumPerMovie
FROM ticket ticket  
JOIN schedule schedule ON schedule.id = ticket.schedule_id
JOIN movie movie ON movie.id = schedule.movie_id
GROUP BY movie.id
ORDER BY sumPerMovie DESC