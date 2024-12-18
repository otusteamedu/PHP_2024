SELECT 
    films.name AS film_name, 
    SUM(tickets.final_price) AS cash 
FROM tickets AS tickets 
LEFT JOIN sessions AS sessions 
    ON sessions.id = tickets.session_id 
LEFT JOIN films AS films 
    ON films.id = sessions.film_id 
WHERE tickets.status = 'paid' 
GROUP BY films.name 
ORDER BY cash DESC
LIMIT 1;