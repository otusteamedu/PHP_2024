select name SUM(price) AS total_profit from Sessions
         join Movies on movie_id = id
         join Halls on hall_is = id
         join Tickets on id = session_id
where is_sold = true
group by name
order by total_profit DESC
limit 1