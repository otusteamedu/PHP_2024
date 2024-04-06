\c cinema;

CREATE INDEX indx_tickets_place ON tickets (place);
CREATE INDEX indx_tickets_session_id ON tickets (session_id);
CREATE INDEX indx_session_movie_index on sessions(movie_id);

EXPLAIN ANALYSE
SELECT id, row, place
FROM tickets
where place > 10;

EXPLAIN ANALYSE
SELECT id, row, place, session_id
FROM tickets
where place > 10
ORDER BY session_id;


EXPLAIN ANALYSE
SELECT session_id, count(id)
FROM tickets
GROUP BY session_id;


EXPLAIN ANALYSE
SELECT movie_id, COUNT(s.id)
FROM tickets
         JOIN sessions s on s.id = tickets.session_id
WHERE movie_id = 1
GROUP BY movie_id;


EXPLAIN ANALYSE
SELECT m.name, sum(t.selling_price) as sum
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC;
