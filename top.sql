SELECT 
    m.title AS movie_title, 
    SUM(t.price) AS total
FROM 
    movie m
JOIN 
    screening s ON m.movie_id = s.id
JOIN 
    ticket t ON s.screening_id = t.id
GROUP BY 
    m.title
ORDER BY 
    total DESC
LIMIT 1;
