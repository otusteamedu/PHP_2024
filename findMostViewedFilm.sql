SELECT f.name,SUM(amount)
FROM tickets
        JOIN sessions s on tickets.sessionid = s.id
        JOIN films f on f.id = s.filmid
        GROUP BY f.name
ORDER BY sum DESC LIMIT 1;