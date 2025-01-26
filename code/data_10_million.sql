Create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

-- Наполнение таблицы clients (Клиенты)
insert into clients (id, surname, name, email, phone, age)
select gs.id,
       concat('surname-', random_string(((random() * (15 - 3 + 1)) + 3)::integer)),
       concat('name-', random_string(((random() * (8 - 3 + 1)) + 3)::integer)),
       concat('email', ((random() * (1000 - 100 + 1))::integer + 100), '@',
              (case (floor(random() * 2))
                   when 0 then 'mail'
                   when 1 then 'yandex'
                   when 2 then 'rambler'
                  end), '.ru'),
       concat('+79', substr((random() * 10000000000)::varchar, 1, 9)),
       ((random() * (85 - 16 + 1)) + 16)::integer
from generate_series(1, 1500) as gs(id);

-- Наполнение таблицы genres (Жанры)
insert into genres (id, name)
values (1, 'Ужасы'),
       (2, 'Боевик'),
       (3, 'Мелодрама'),
       (4, 'Драма'),
       (5, 'Комедия');

-- Наполнение таблицы movies (Фильмы)
insert into movies(id, genre_id, name, description, duration, age_limit, rating)
select gs.id,
       (floor(random() * 5 + 1)),
       concat('movie-', random_string(((random() * (8 - 3 + 1)) + 3)::integer)),
       concat('description-', random_string(((random() * (50 - 10 + 1)) + 10)::integer)),
       ((random() * (120 - 60 + 1)) + 60)::integer,
       ((random() * (21 - 6 + 1)) + 6)::integer,
       CAST((random() * 4 + 1) AS decimal(2, 1))
from generate_series(1, 1000000) as gs(id);

-- Наполнение таблицы halls (Кинозалы)
insert into halls(id, name, seat_count)
select gs.id,
       concat('Зал_', random_string(5)),
       160
from generate_series(1, 5) as gs(id);

-- Наполнение таблицы seats (Места кинозала)
-- В каждом зале 8 рядов по 20 мест, в сумме 160 мест
do
$$
    begin
        for hall in 1..5
            loop
                for row in 1..8
                    loop
                        insert into seats(hall_id, number, row)
                        select hall,
                               number,
                               row
                        from generate_series(1, 20) as number;
                    end loop;
            end loop;
    end;
$$ language plpgsql;

-- Наполнение таблицы sessions (Сеансы)
-- В каждом зале 7 показов фильмов в день на протяжении 1095 дней
do
$$
    declare
        start_time  timestamp;
    begin
        for day in 1..1825
            loop
                for hall in 1..5
                    loop
                        start_time = now()::date - (1825 - day || ' days')::interval;
                        insert into sessions(hall_id, movie_id, started_at, ended_at)
                        select hall,
                               ((random() * (10000 - 1) + 1))::integer,
                               start_time + (1 || ' days')::interval,
                               start_time + (1 || ' days')::interval + concat((60 + random() * 180)::integer, ' minutes')::interval
                        from generate_series(1, 7) as gs(id);
                    end loop;
            end loop;
    end;
$$ language plpgsql;

-- Наполнение таблицы prices (Цены)
insert into prices(session_id, seat_id, price)
select sessions.id as session_id,
       seats.id as seat_id,
       CAST((random() * (500 - 250) + 1) AS decimal(5, 2))
from sessions
         left join halls on sessions.hall_id = halls.id
         right join seats on seats.hall_id  = halls.id;

-- Наполнение таблицы tickets (Билеты)
insert into tickets (client_id, price_id, price, sale_at)
select ((random() * (1500 - 1) + 1))::integer as client_id,
       prices.id as price_id,
       prices.price,
       (sessions.started_at + random() * (sessions.ended_at - sessions.started_at)) as sale_at
from prices
         join public.sessions on sessions.id = prices.session_id
order by random()
limit 10000000;
