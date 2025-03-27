Create or replace function random_string(length integer) returns text as
$$
declare
    chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text := '';
    i integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length loop
            result := result || chars[1+random()*(array_length(chars, 1)-1)];
        end loop;
    return result;
end;
$$ language plpgsql;


TRUNCATE halls,
    movies,
    places,
    sessions,
    tickets,
    clients,
    orders,
    order_tickets CASCADE;

-- halls

INSERT INTO halls (id, name)
SELECT id,
       CONCAT('hall_', random_string(10))
FROM generate_series(1, 10000) AS id;

-- movies

INSERT INTO movies (id, title, YEAR)
SELECT id,
       CONCAT('movie_', random_string(20)),
       1980 + RANDOM() * 45
FROM generate_series(1, 10000) AS id;

-- places

INSERT INTO places (id, ROW, seat)
SELECT id,
       1 + RANDOM() * 30,
       1 + RANDOM() * 30
FROM generate_series(1, 10000) AS id;

-- sessions

INSERT INTO sessions (id, date, start_time, hall_id, movie_id)
SELECT id,
       (now()::date - (RANDOM() * 30)::int)::date,
       date_trunc('minute', ('09:00'::TIME + (random() * ('22:00'::TIME - '09:00'::TIME)))::TIME),
       1 + RANDOM() * 9999,
       1 + RANDOM() * 9999
FROM generate_series(1, 10000) AS id;

-- tickets

INSERT INTO tickets (id, session_id, place_id, price)
SELECT id,
       1 + RANDOM() * 9999,
       1 + RANDOM() * 9999,
       1 + RANDOM() * 500
FROM generate_series(1, 10000) AS id;

-- clients

INSERT INTO clients (id, name, phone)
SELECT id,
       CONCAT('client_', random_string(20)),
       CONCAT('7', (RANDOM() * 100000000)::int)
FROM generate_series(1, 10000) AS id;

-- orders

INSERT INTO orders (id, client_id, total)
SELECT id,
       1 + RANDOM() * 9999,
       1 + RANDOM() * 1000
FROM generate_series(1, 10000) AS id;

-- order_tickets

INSERT INTO order_tickets (id, order_id, ticket_id, price)
SELECT id,
       1 + RANDOM() * 9999,
       1 + RANDOM() * 9999,
       1 + RANDOM() * 1000
FROM generate_series(1, 10000) AS id;

