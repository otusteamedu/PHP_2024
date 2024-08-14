SELECT movie_id, SUM(price) as sum FROM tickets
    JOIN sessions ON session_id = sessions.id
    JOIN seats ON seat_id = seats.id
GROUP BY movie_id
ORDER BY sum
DESC LIMIT 1;;