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
       '2025-01-01',
       '2025-12-31',
       floor(random() * 10000) + 5000 AS random_integer
FROM generate_series(1, 16) AS id;

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
                    FROM generate_series(1, 30) AS num
                             JOIN (SELECT row FROM generate_series(1, 3) AS row) ON (num - 1) / 10 = row - 1) AS t1
                   ON 1 = 1;

-- sessions
INSERT INTO sessions (start_time)
VALUES ('10:00:00'),
       ('12:00:00'),
       ('14:00:00'),
       ('16:00:00'),
       ('18:00:00'),
       ('20:00:00');

-- pivot_with_base_prices
INSERT INTO pivot_with_base_prices (hall_id, film_id, session_id, base_price)
SELECT halls.id,
       films.id,
       sessions.id,
       floor(random() * 100) + 50 AS random_integer
FROM films
         FULL JOIN halls ON 1 = 1
         FULL JOIN sessions ON 1 = 1;

-- tickets 10_000
-- INSERT INTO tickets (id_pivot_with_base_prices, seat_id, session_date, real_price)
-- SELECT t1.pwbp_id, t1.seat_id, t1.dat, t1.sale_price
-- FROM (SELECT pwbp.id                                                as pwbp_id,
--              s.id                                                   as seat_id,
--              '2025-01-01'::DATE + num_dat                           as dat,
--              CASE WHEN random() > 0.8 THEN pwbp.base_price - 20 END AS sale_price
--       FROM generate_series(0, ('2025-12-31'::DATE - '2025-01-01'::DATE)) num_dat
--                FULL JOIN pivot_with_base_prices pwbp ON 1 = 1
--                FULL JOIN seats s ON 1 = 1) AS t1
-- WHERE random() < 0.000096;

-- tickets 10_000_000
INSERT INTO tickets (id_pivot_with_base_prices, seat_id, session_date, real_price)
SELECT t1.pwbp_id, t1.seat_id, t1.dat, t1.sale_price
FROM (SELECT pwbp.id                                                AS pwbp_id,
             s.id                                                   AS seat_id,
             '2025-01-01'::DATE + num_dat                           AS dat,
             CASE WHEN random() > 0.8 THEN pwbp.base_price - 20 END AS sale_price
      FROM generate_series(0, ('2025-12-31'::DATE - '2025-01-01'::DATE)) num_dat
               FULL JOIN pivot_with_base_prices pwbp ON 1 = 1
               FULL JOIN seats s ON 1 = 1) AS t1
WHERE random() < 0.096;





