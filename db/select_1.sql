--1. Выбор всех фильмов на сегодня

SELECT films.name from films
    Join cinema_shows on cinema_shows.film_id = films.id
    where cinema_shows.date = CURRENT_DATE
    order by films.name ASC