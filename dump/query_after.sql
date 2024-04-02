\c cinema;

CREATE INDEX indx_tickets_place ON tickets (place);
CREATE INDEX indx_tickets_session_id ON tickets (session_id);
CREATE INDEX indx_tickets_zone_id ON tickets (zone_id);

EXPLAIN ANALYSE
    SELECT id, row, place
FROM tickets where place > 10;

EXPLAIN ANALYSE
    SELECT id, row, place, session_id
FROM tickets where place > 10 ORDER BY session_id;


EXPLAIN ANALYSE
    SELECT session_id, count(id)
FROM tickets GROUP BY session_id;

EXPLAIN ANALYSE
    SELECT m.name, p.price as sum
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 100 and z.number_of_seats > 40;

EXPLAIN ANALYSE
    SELECT m.name, p.price
FROM tickets
         LEFT JOIN sessions s on s.id = tickets.session_id
         LEFT JOIN zones z on z.id = tickets.zone_id
         LEFT JOIN prices p on z.id = p.zone_id
         LEFT JOIN movies m on s.movie_id = m.id
WHERE p.price > 300 ORDER BY p.price;

EXPLAIN ANALYSE
    SELECT m.name, sum(t.selling_price) as sum
FROM tickets as t
         LEFT JOIN sessions s on s.id = t.session_id
         LEFT JOIN movies m on s.movie_id = m.id
GROUP BY m.id
ORDER BY sum DESC;
