SELECT DISTINCT f.name, s.begin_time, h.name FROM cinema_sessions as s 
  INNER JOIN cinema_films as f ON s.id_film = f.uuid
  INNER JOIN cinema_halls as h ON s.id_hall = h.uuid
WHERE begin_date = current_date
ORDER BY s.begin_time, h.name