SELECT 
    m.name,
    SUM(t.Price) AS Total_profit
FROM 
    Tickets t
JOIN 
    Sessions s ON t.Session_ID = s.ID
JOIN 
    Movies m ON s.Movie_ID = m.ID
GROUP BY 
    m.name
ORDER BY 
    Total_profit DESC
LIMIT 1;
