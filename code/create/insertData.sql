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

-- Клиенты
insert into customers (id, name, phone)
select gs.id,
       concat('name-', random_string((3 + random() * 5)::integer)),
       concat('+79', substr((random() * 10000000000)::varchar, 1, 9))
from generate_series(1, 1000) as gs(id);

-- 5 жанров
insert into genres (id, name)
VALUES (1, 'драма'),
       (2, 'триллер'),
       (3, 'комедия'),
       (4, 'боевик'),
       (5, 'хоррор');

-- 50 фильмов
insert into movies(id, title, duration, genre_id, rating)
select gs.id,
       concat('movie_', random_string((3 + random() * 5)::integer)),
       (3600 + random() * 7200),
       (floor(random() * 5 + 1)),
       CAST((random() * 4 + 1) AS decimal(2, 1))
from generate_series(1, 50) as gs(id);

-- 6 залов
insert into halls(id, name, seats)
select gs.id,
       concat('Зал_', random_string(3)),
       (floor(10 + random() * 60))
from generate_series(1, 6) as gs(id);

-- 15 рядов по 25 мест в каждом зале
do
$$
    begin
        for h in 1..6
            loop
                for rn in 1..15
                    loop
                        insert into seats(hall_id, row_number, seat_number)
                        select h,
                               rn,
                               sn
                        from generate_series(1, 25) as sn;
                    end loop;
            end loop;
    end;
$$ language plpgsql;

-- 5 показов в день для каждого зала для последних 30 дней
do
$$
    declare
        start_time timestamp;
    begin
        for d in 1..30
            loop
                for h in 1..6
                    loop
                        start_time = now()::date - (30 - d || ' days')::interval;
                        insert into sessions(movie_id, hall_id, start_time, end_time)
                        select (1 + random() * 5)::integer,
                               h,
                               start_time,
                               start_time + ((60 + random() * 180)::integer || ' minutes')::interval
                        from generate_series(1, 5) as gs(id);
                    end loop;
            end loop;
    end;
$$ language plpgsql;

-- Установка цен
insert into ticket_prices (session_id, seat_id, price)
select sessions.id as session_id, seats.id as seat_id, CAST((random() * 1000 + 300) AS decimal(6, 2))
from seats
         join halls on seats.hall_id = halls.id
         join sessions on sessions.hall_id = halls.id;

-- Билеты
insert into tickets (ticket_price_id, customer_id, price, purchased_at)
select t.id                                                    as ticket_price_id,
       floor(random() * 1000 + 1)                              as customer_id,
       t.price,
       (s.start_time + random() * (s.end_time - s.start_time)) as purchased_at
from ticket_prices t
         join public.sessions s on s.id = t.session_id
order by random() limit 10000;

-- truncate table sessions, movies, movie_attributes, seats, tickets, ticket_prices, genres, halls, customers, attributes, attribute_types;
-- select count(*) from tickets;

