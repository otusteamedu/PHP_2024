SELECT films.name, sum(tickets.price)
FROM tickets
         LEFT JOIN sessions ON tickets.session_id = sessions.id
         LEFT JOIN films ON sessions.film_id = films.id
WHERE tickets.sold_at IS NOT NULL
GROUP BY films.name
ORDER BY sum(tickets.price) DESC
LIMIT 1;