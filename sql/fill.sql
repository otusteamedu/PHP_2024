-- генерация кинотеатров
insert into cinema (name)
select 'cinema ' || i
from generate_series(1, 10000) as i;

-- генерация залов
insert into hall (name, capacity, cinema_id)
select
    'hall ' || i,
    (random() * 100 + 50)::smallint,
    (select id from cinema order by random() limit 1)
from generate_series(1, 10000) as i;

-- генерация режиссеров
insert into directors (name)
select 'director ' || i
from generate_series(1, 10000) as i;

-- генерация фильмов
insert into movies (name, duration, release_year, director_id, genre)
select
    'movie ' || i,
    (random() * 120 + 60)::smallint,
    (random() * 30 + 1990)::smallint,
    (select id from directors order by random() limit 1),
    'genre ' || (random() * 10 + 1)::int
from generate_series(1, 10000) as i;

-- генерация актеров
insert into actors (name)
select 'actor ' || i
from generate_series(1, 10000) as i;

-- генерация связной таблицы
insert into movies_actors (movie_id, actor_id)
select
    (random() * 10000 + 1)::bigint,
    (select id from actors order by random() limit 1)
from generate_series(1, 10000) as i;

-- генерация сеансов
insert into sessions (movie_id, hall_id, price, start_time, end_time)
select
    (select id from movies order by random() limit 1),
    (select id from hall order by random() limit 1),
    (random() * 500 + 100)::integer,
    now() + (random() * 100)::int * interval '1 minute',
    now() + (random() * 100)::int * interval '1 minute' + interval '2 hour'
from generate_series(1, 10000) as i;



------------- 10 000 000 ----------------
-- генерация кинотеатров
insert into cinema (name)
select 'cinema ' || i
from generate_series(1, 10000000) as i;

-- генерация залов
insert into hall (name, capacity, cinema_id)
select
    'hall ' || i,
    (random() * 100 + 50)::smallint,
    (select id from cinema order by random() limit 1)
from generate_series(1, 10000000) as i;

-- генерация режиссеров
insert into directors (name)
select 'director ' || i
from generate_series(1, 10000000) as i;

-- генерация фильмов
insert into movies (name, duration, release_year, director_id, genre)
select
    'movie ' || i,
    (random() * 120 + 60)::smallint,
    (random() * 30 + 1990)::smallint,
    (select id from directors order by random() limit 1),
    'genre ' || (random() * 10 + 1)::int
from generate_series(1, 10000000) as i;

-- генерация актеров
insert into actors (name)
select 'actor ' || i
from generate_series(1, 10000000) as i;

-- генерация связной таблицы
insert into movies_actors (movie_id, actor_id)
select
    (select id from movies order by random() limit 1),
    (select id from actors order by random() limit 1)
from generate_series(1, 50000000) as i;

-- генерация сеансов
insert into sessions (movie_id, hall_id, price, start_time, end_time)
select
    (select id from movies order by random() limit 1),
    (select id from hall order by random() limit 1),
    (random() * 500 + 100)::integer,
    now() + (random() * 100)::int * interval '1 minute',
    now() + (random() * 100)::int * interval '1 minute' + interval '2 hour'
from generate_series(1, 10000000) as i;