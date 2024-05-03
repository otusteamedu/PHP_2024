INSERT INTO halls (id, name)
VALUES (1, 'Зал 1');
INSERT INTO halls (id, name)
VALUES (2, 'Зал 2');
INSERT INTO halls (id, name)
VALUES (3, 'Зал 3');
INSERT INTO halls (id, name)
VALUES (4, 'Зал 4');
INSERT INTO halls (id, name)
VALUES (5, 'Зал 5');


INSERT INTO countries (id, name)
VALUES (1, 'РФ');
INSERT INTO countries (id, name)
VALUES (2, 'РБ');
INSERT INTO countries (id, name)
VALUES (3, 'Италия');
INSERT INTO countries (id, name)
VALUES (4, 'Испания');


insert into films (id, name, year_date, description, duration)
select gs.id,
       random_film_name() || ' ' || random_str((1 + random() * 30)::integer),
       random_int(1960, 2020),
       random_str((2 + random() * 25)::integer),
       random_int(100, 250)
from generate_series(1, 1000000) as gs(id);


INSERT INTO seats (id, hall_id, seat_number, row_number)
select gs.id,
       random_int(1, 5),
       random_int(1, 20),
       random_int(1, 20)
from generate_series(1, 100) as gs(id);


INSERT INTO films_sessions (id, hall_id, film_id, start_time, end_time, base_price)
select gs.id,
       random_int(1, 5),
       random_int(1, 1000000),
       random_timestamp(),
       random_timestamp(),
       random_int(1, 100)
from generate_series(1, 1000000) as gs(id);


INSERT INTO tickets (id, session_id, seat_id, price, pay_time)
select gs.id,
       random_int(1, 1000000),
       random_int(1, 100),
       random_int(1, 100),
       random_timestamp()
from generate_series(1, 1000000) as gs(id);
