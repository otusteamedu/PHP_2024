-- 1
SELECT * FROM films WHERE date = '2023-04-11'

-- 2
SELECT count(id) FROM tickets
WHERE sold = true AND sold_at < CURRENT_DATE::timestamp AND sold_at > (now()::date - interval '7 days')::timestamp

-- 3
SELECT id FROM movie_sessions
WHERE start_at > CURRENT_DATE::timestamp AND start_at < (now()::date + interval '1 day')::timestamp

-- 4
SELECT tickets.session_id, SUM(tickets.price) as total, movie_sessions.film_id FROM tickets
LEFT JOIN movie_sessions ON movie_sessions.id = tickets.session_id
WHERE
    tickets.sold = true AND
    tickets.sold_at < CURRENT_DATE::timestamp AND
    tickets.sold_at > (now()::date - interval '7 days')::timestamp
GROUP BY tickets.session_id, movie_sessions.film_id
ORDER BY total DESC
LIMIT 3

-- 5
SELECT tickets.session_id, tickets.id, rooms_places.id, rooms_places.name, rooms_places.row, rooms_places.number, tickets.sold FROM tickets
                                                                                                                                        LEFT JOIN rooms_places ON rooms_places.id = tickets.place_id
WHERE tickets.session_id = 1
GROUP BY tickets.id, rooms_places.id;

-- 6
SELECT MAX(max_tickets.price) as max_price, MIN(min_tickets.price) as min_price FROM tickets as max_tickets, tickets as min_tickets
WHERE max_tickets.session_id = 2 AND min_tickets.session_id = 2
