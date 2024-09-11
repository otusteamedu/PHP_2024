---6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

SELECT max(titkets.pice) as MAXIMUM, min(tickets.price) AS MINUMUM
    from tickets
    join cinema_show_seat on cinema_show_seat.id = tickets.cinema_show_seat_id
    WHERE cinema_show_seat.cinema_show_id = 1

select max(ticket.price), min(ticket.price)
    from ticket
    where ticket.showtime_id = 1