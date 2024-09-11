---4. Поиск 3 самых прибыльных фильмов за неделю

SELECT films.name, sum(tickets.price) as total_summ
    from tickets
    JOIN cinema_shows_seat on cinema_shows_seat.id = tickets.cinema_show_seat_id
    JOIN cinema_shows on cinema_shows.id = cinema_show_seat.cinema_show_id
    JOIN films on films.id = cinema_shows.film_id
    WHERE cinema_shows.date BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE
    ORDER by total_summ desc
    LIMIT 3