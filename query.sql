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

ALTER TABLE Sessions ADD COLUMN Base_Price DECIMAL(10, 2); --До покупки узнаем стоимость
ALTER TABLE Sessions ADD COLUMN Dynamic_Price DECIMAL(10, 2); 
UPDATE Sessions
SET Dynamic_Price = m.Base_Price 
    * pr.Price_Coefficient
    * ht.Price_Coefficient
    * mr.Price_Coefficient
FROM Sessions s
JOIN Movies m ON s.Movie_ID = m.ID
JOIN Halls h ON s.Hall_ID = h.ID
JOIN PricingRules pr ON pr.Day_of_Week = TO_CHAR(s.Дата_и_время, 'Day')
                     AND pr.Time_of_Day = CASE 
                                          WHEN EXTRACT(HOUR FROM s.Дата_и_время) BETWEEN 6 AND 12 THEN 'утро'
                                          WHEN EXTRACT(HOUR FROM s.Дата_и_время) BETWEEN 12 AND 18 THEN 'день'
                                          WHEN EXTRACT(HOUR FROM s.Дата_и_время) BETWEEN 18 AND 24 THEN 'вечер'
                                          ELSE 'ночь'
                                          END
JOIN HallTypes ht ON h.Hall_Type = ht.Hall_Type
JOIN MovieRating mr ON m.ID = mr.Movie_ID;

