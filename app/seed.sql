create or replace function random_string(length integer) returns text as
    $$
    declare
        chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
        result text := '';
        i integer := 0;
    begin
        if length < 0 then
            raise exception 'error';
        end if;
        for i in 1..length loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
        return result;
    end;
    $$ language plpgsql;

INSERT INTO films (id, name, date)
SELECT
    gs.id,
    random_string((1 + random() * 29)::integer),
    '2014-01-01'::date + (random() * (NOW() + '11 years' - NOW()))
FROM generate_series(1, 10000) as gs(id);

INSERT INTO rooms (id, name)
SELECT
    gs.id,
    gs.id
FROM generate_series(1, 4) as gs(id);


INSERT INTO rooms_places (id, room_id, name, row, number)
SELECT
    gs.id,
    1,
    random_string((1 + random() * 29)::integer),
    ((gs.id - 1) / 100)::integer + 1,
    ((gs.id - 1) % 100)::integer + 1
FROM generate_series(1, 50) as gs(id);

INSERT INTO rooms_places (id, room_id, name, row, number)
SELECT
    gs.id,
    2,
    random_string((1 + random() * 29)::integer),
    ((gs.id - 1) / 100)::integer + 1,
    ((gs.id - 1) % 100)::integer + 1
FROM generate_series(51, 100) as gs(id);

INSERT INTO rooms_places (id, room_id, name, row, number)
SELECT
    gs.id,
    3,
    random_string((1 + random() * 29)::integer),
    ((gs.id - 1) / 100)::integer + 1,
    ((gs.id - 1) % 100)::integer + 1
FROM generate_series(101, 150) as gs(id);

INSERT INTO rooms_places (id, room_id, name, row, number)
SELECT
    gs.id,
    4,
    random_string((1 + random() * 29)::integer),
    ((gs.id - 1) / 100)::integer + 1,
    ((gs.id - 1) % 100)::integer + 1
FROM generate_series(151, 200) as gs(id);

INSERT INTO movie_sessions (id, film_id, room_id, start_at, duration)
SELECT
    gs.id,
    gs.id,
    ((gs.id - 1) / 2500)::integer + 1,
    ('2014-01-01'::date + (random() * (NOW() + '11 years' - NOW())))::timestamp,
    '02:00:00'::time
FROM generate_series(1, 10000) as gs(id);

INSERT INTO tickets (id, session_id, place_id, price, sold, sold_at)
SELECT
    gs.id,
    ((gs.id - 1) / 200)::integer + 1,
    ((gs.id - 1) % 200)::integer + 1,
    (random() * 150 + 350)::integer,
    random() > 0.7,
    ('2014-01-01'::date + (random() * (NOW() + '11 years' - NOW())))::timestamp
FROM generate_series(1, 2000000) as gs(id);
