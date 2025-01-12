SELECT DISTINCT f.name FROM cinema_sessions as s 
  INNER JOIN cinema_films as f ON s.id_film = f.uuid
WHERE begin_date = current_date