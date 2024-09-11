---5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

SELECT seats.row, seats.place, (case when tickets.id is not null then 1 else 0 end) as status from seats
    JOIN halls on halls.id = seats.hall_id
    JOIN cinema_shows on cinema_shows.hall_id = halls.id
    JOIN cinema_show_seat on cinema_show_seat.cinema_show_id = cinema_shows.id
    LEFT JOIN tickets on tickets.cinema_show_seat_id = cinema_show_seat.id
    WHERE cinema_shows.id = 1