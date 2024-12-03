select name, SUM(price) AS total_profit from Tickets 
    left join Sessions on Tickets.session_id = Sessions.id 
    left join Movies on Sessions.movie_id = Movies.id 
where is_sold = 1 
group by name 
order by total_profit DESC 
limit 1;