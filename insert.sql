
-- FUNCTIONS

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


-- INSERT DATA

INSERT INTO halls (id, name, type)
VALUES (1, 'Зал 1', 'COMMON'),
       (2, 'Зал 2', 'IMAX');


INSERT INTO hall_seats (id, hall_id, number, price_coefficient, max_count)
VALUES (1, 1, 'A1', 1, 1),
       (2, 1, 'B1', 1, 1),
       (3, 1, 'C1', 1.5, 2),
       (4, 1, 'D1', 1.5, 2),
       (5, 1, 'E1', 2, 2),
       (6, 1, 'F1', 2, 2),
       (7, 1, 'G1', 2.5, 2),
       (8, 2, 'A1', 1, 1),
       (9, 2, 'B1', 1, 1),
       (10, 2, 'C1', 1.5, 2),
       (11, 2, 'D1', 1.5, 2),
       (12, 2, 'E1', 2, 2),
       (13, 2, 'F1', 2, 2),
       (14, 2, 'G1', 2.5, 2);


INSERT INTO times (id, time)
VALUES (1, '10:00'),
       (2, '10:30'),
       (3, '11:00'),
       (4, '13:00'),
       (5, '17:00'),
       (6, '19:00');


INSERT INTO films (id, name, year, start_date)
select gs.id,
       random_string(30),
       floor(random() * (2024 - 2001 + 1) + 2001)::int,
        timestamp '2014-01-10 20:00:00' +
            random() * (timestamp '2025-01-01 20:00:00' -
                        timestamp '2025-01-30 10:00:00')
from generate_series(1, 10000000) as gs(id);


INSERT INTO countries (id, name)
select gs.id,
       random_string(30)
from generate_series(1, 100) as gs(id);


INSERT INTO country_film (country_id, film_id)
select floor(random() * 100 + 1)::int,
        floor(random() * 10000000 + 1)::int
from generate_series(1, 100) as gs(id);


INSERT INTO sessions (id, hall_id, film_id, time_id, date, price)
select gs.id,
       floor(random() * 2 + 1)::int,
        floor(random() * 10000000 + 1)::int,
        floor(random() * 6 + 1)::int,
        TO_DATE((timestamp '2025-01-01 20:00:00' +
                 random() * (timestamp '2025-01-30 20:00:00' -
                             timestamp '2025-01-01 10:00:00'))::text, 'YYYY-MM-DD'),
       floor(random() * 700 + 450)::int
from generate_series(1, 10000000) as gs(id);


INSERT INTO clients (id, name)
select gs.id,
       random_string(30)
from generate_series(1, 100) as gs(id);


INSERT INTO tickets (id, client_id, session_id, hall_seat_id, session_price, seat_price_coefficient)
select gs.id,
       floor(random() * 100 + 1)::int,
        floor(random() * 10000000 + 1)::int,
        floor(random() * 14 + 1)::int,
        floor(random() * 700 + 450)::int,
        floor(random() * 1 + 2)
from generate_series(1, 10000000) as gs(id);


