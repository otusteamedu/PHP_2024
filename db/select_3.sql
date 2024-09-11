---3. Формирование афиши (фильмы, которые показывают сегодня)

SELECT films.name, cinema_shows.start, halls.name from films 
    JOIN cinema_shows on cinema_shows.film_id = films.id
    JOIN halls on halls.id = cinema_shows.hall_id
    WHERE cinema_shows.date = CURRENT_DATE
    order by cinema_shows.start