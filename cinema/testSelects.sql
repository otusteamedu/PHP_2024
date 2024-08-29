-- 1. Выбор всех фильмов на сегодня
select movies.name as movies_today from movies join shows on movies.id = shows.movieId
where shows.startAt::date = now()::date
group by movies.name;

-- 2. Подсчёт проданных билетов за неделю
select count(*) from tickets where tickets.soldAt > now() - interval '7 days';

-- 3. Формирование афиши (фильмы, которые показывают сегодня)
select movies.name as movies_today, shows.startAt, halls.name as hall from movies
  join shows on movies.id = shows.movieId
  join halls on shows.hallId = halls.id
where shows.startAt::date = now()::date
order by shows.startAt;

-- 4. Поиск 3 самых прибыльных фильмов за неделю
select movies.name, count(*), sum(soldprice) from tickets
  join shows on shows.id = tickets.showId
  join movies on movies.id = shows.movieId
where tickets.soldAt > now() - interval '7 days'
group by movies.name
order by sum desc
limit 3

-- 5. Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
create extension if not exists tablefunc;
select * from crosstab(
    $$
        select 
            rows.row as row_number,
            seats.seat as seat_number,
            (case when tickets.soldAt is not null then 'x' end) AS value
        from seats
        join rows on rows.id = seats.rowId
        join halls on halls.id = rows.hallId
        join shows on shows.hallId = halls.id
        left join tickets ON tickets.showId = shows.id and tickets.seatId = seats.id
        where shows.id = 42
        order by rows.row, seats.seat
    $$,
    $$
        select distinct seats.seat 
        from seats 
        order by seats.seat
    $$
) as ct(row int, "1" text, "2" text, "3" text, "4" text, "5" text, 
              "6" text, "7" text, "8" text, "9" text, "10" text, 
              "11" text, "12" text, "13" text, "14" text, "15" text, 
              "16" text, "17" text, "18" text, "19" text, "20" text, 
              "21" text, "22" text, "23" text, "24" text, "25" text);

-- 6. Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
select min(soldprice) || ' - ' || max(soldprice) as price from tickets
where showId = 42
group by tickets.showId;