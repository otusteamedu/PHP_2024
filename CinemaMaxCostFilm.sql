SELECT 
	cinema_films.title AS name_film,
	SUM(cinema_tickets.price) AS summa
FROM cinema_tickets  
LEFT JOIN cinema_sessions  
	LEFT JOIN cinema_films ON (cinema_sessions.id_film = cinema_films.id)
ON (cinema_tickets.id_session= cinema_sessions.id)
GROUP BY name_film
ORDER BY summa DESC LIMIT 1