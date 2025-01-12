SELECT COUNT(*) FROM cinema_tickets as t  
  INNER JOIN cinema_sessions as s ON s.uuid = t.id_session 
WHERE t.sold AND begin_date >= '2025-01-06' AND begin_date <= '2025-01-12'