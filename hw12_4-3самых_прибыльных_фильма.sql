SELECT s.name, SUM(price) as price FROM cinema_tickets as t  
  INNER JOIN (
    SELECT s.uuid, s.begin_date, f.name FROM cinema_sessions as s 
  				INNER JOIN cinema_films as f ON f.uuid = s.id_film 
				  AND s.begin_date >= '2025-01-06' AND s.begin_date <= '2025-01-12'
  ) as s ON s.uuid = t.id_session
WHERE t.sold
GROUP BY s.name
ORDER BY price DESC
LIMIT 3