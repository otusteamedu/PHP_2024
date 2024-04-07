\c cinema;

DROP INDEX IF EXISTS indx_tickets_place;
DROP INDEX IF EXISTS indx_tickets_session_id;
DROP INDEX IF EXISTS indx_session_movie_id;
DROP INDEX IF EXISTS indx_tickets_sale_at;

EXPLAIN ANALYSE
    SELECT id, row, place
FROM tickets where place > 10;

EXPLAIN ANALYSE
    SELECT id, row, place, session_id
FROM tickets where place > 10 ORDER BY session_id;


EXPLAIN ANALYSE
SELECT count(t.id) as tickets_sold_last_week
FROM tickets as t
WHERE t.sale_at > (now() - interval '7 day');


EXPLAIN ANALYSE
SELECT m.name, sum(t.selling_price) as sum, count(t.id) as tickets_count
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE t.sale_at > (now() - interval '7 day')
GROUP BY m.name
ORDER BY sum DESC
LIMIT 3;


EXPLAIN ANALYSE
SELECT m.name, MIN(t.selling_price) as min_sell_price, MAX(t.selling_price) as max_sell_price
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE s.id = 2
GROUP BY m.name;