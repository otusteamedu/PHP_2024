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

-- films
INSERT INTO films (id, title, start_date, end_date, rental_cost)
SELECT id,
       CONCAT('film__', random_string(5)),
       (ARRAY['2025-01-01','2025-02-01','2025-03-01'])[floor(random()*3)+1]::DATE,
       (ARRAY['2025-05-31','2025-08-31','2025-12-31'])[floor(random()*3)+1]::DATE,
       floor(random() * 100) + 500 AS random_integer
FROM generate_series(1, 15) AS id;

-- halls
INSERT INTO halls (id, title)
SELECT id,
       CONCAT('hall__', random_string(5))
FROM generate_series(1, 10) AS id;

-- seats
INSERT INTO seats (num, row, hall_id)
SELECT num, row, h.id
FROM halls h
         FULL JOIN (SELECT num, row
                    FROM generate_series(1, 50) AS num
                             JOIN (SELECT row FROM generate_series(1, 5) AS row) ON (num - 1) / 10 = row - 1) AS t1
                   ON 1 = 1;

-- sessions
INSERT INTO sessions (start_time)
VALUES ('08:00:00'),
       ('10:00:00'),
       ('12:00:00'),
       ('14:00:00'),
       ('16:00:00'),
       ('18:00:00'),
       ('20:00:00'),
       ('22:00:00');

-- random_tickets_with_base_prices
INSERT INTO random_tickets_with_base_prices (hall_id, film_id, session_id, base_price)
SELECT h.id,
       f.id,
       s.id,
       CASE WHEN random() < 0.7 THEN f.rental_cost - 20 ELSE f.rental_cost END
FROM films f
         FULL JOIN halls h ON 1 = 1
         FULL JOIN sessions s ON 1 = 1;

-- tickets 10_000
-- INSERT INTO tickets (random_tickets_with_base_prices_id, seat_id, session_date, real_price)
-- SELECT t1.film_id, t1.seat_id, t1.date, t1.sale_price
-- FROM (SELECT rtwbp.id                as film_id,
--              s.id                         as seat_id,
--              '2025-01-01'::DATE + num_dat as date,
--              rtwbp.base_price             AS sale_price
--       FROM generate_series(0, ('2025-12-31'::DATE - '2025-01-01'::DATE)) num_dat
--                FULL JOIN random_tickets_with_base_prices rtwbp ON 1 = 1
--                FULL JOIN seats s ON 1 = 1) AS t1
-- WHERE random() < 0.000096;

-- tickets 10_000_000
INSERT INTO tickets (random_tickets_with_base_prices_id, seat_id, session_date, real_price)
SELECT t1.film_id, t1.seat_id, t1.date, t1.sale_price
FROM (SELECT rtwbp.id                as film_id,
             s.id                         as seat_id,
             '2025-01-01'::DATE + num_dat as date,
             rtwbp.base_price             AS sale_price
      FROM generate_series(0, ('2025-12-31'::DATE - '2025-01-01'::DATE)) num_dat
               FULL JOIN random_tickets_with_base_prices rtwbp ON 1 = 1
               FULL JOIN seats s ON 1 = 1) AS t1
WHERE random() < 0.096;