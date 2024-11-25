select s1.movie_title m_title, MAX(s1.sum_tickets_prices) max_sum from (
    select movie.title movie_title,
           SUM(t.price) sum_tickets_prices
    from movie
    join session s on movie.id = s.movie_id
    join ticket t on t.session_id = s.id
    group by movie_title)
    s1
group by m_title
order by max_sum DESC
limit 1
;
