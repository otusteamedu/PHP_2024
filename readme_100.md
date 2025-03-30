## Случайные данные:
actors,400
directors,100
genres,20
halls,20
movieactors,493
movies,100
schedules,1000
tickets,1000


-- Запрос для проверки всех билетов на конкретный фильм
```sql
EXPLAIN ANALYZE
SELECT t.*
FROM cinema.Tickets t
         JOIN cinema.Schedules s ON t.schedule_id = s.id
         JOIN cinema.Movies m ON s.movie_id = m.id
WHERE m.title = 'Movie_50';

Hash Join  (cost=24.12..44.97 rows=10 width=22) (actual time=0.157..0.269 rows=12 loops=1)
  Hash Cond: (t.schedule_id = s.id)
  ->  Seq Scan on tickets t  (cost=0.00..17.00 rows=1000 width=22) (actual time=0.014..0.074 rows=1000 loops=1)
  ->  Hash  (cost=24.00..24.00 rows=10 width=4) (actual time=0.135..0.136 rows=15 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Hash Join  (cost=3.26..24.00 rows=10 width=4) (actual time=0.025..0.133 rows=15 loops=1)
              Hash Cond: (s.movie_id = m.id)
              ->  Seq Scan on schedules s  (cost=0.00..18.00 rows=1000 width=8) (actual time=0.002..0.063 rows=1000 loops=1)
              ->  Hash  (cost=3.25..3.25 rows=1 width=4) (actual time=0.011..0.011 rows=1 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movies m  (cost=0.00..3.25 rows=1 width=4) (actual time=0.006..0.009 rows=1 loops=1)
                          Filter: ((title)::text = 'Movie_50'::text)
                          Rows Removed by Filter: 99
Planning Time: 0.271 ms
Execution Time: 0.285 ms
```

-- Список фильмов определенного жанра
```sql
EXPLAIN ANALYZE
SELECT m.*
FROM cinema.Movies m
         JOIN cinema.Genres g ON m.genre_id = g.id
WHERE g.name = 'Genre_5';

Nested Loop  (cost=0.16..12.55 rows=1 width=80) (actual time=0.037..0.072 rows=11 loops=1)
  ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=80) (actual time=0.008..0.015 rows=100 loops=1)
  ->  Memoize  (cost=0.16..0.66 rows=1 width=4) (actual time=0.000..0.000 rows=0 loops=100)
        Cache Key: m.genre_id
        Cache Mode: logical
        Hits: 90  Misses: 10  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using genres_pkey on genres g  (cost=0.15..0.65 rows=1 width=4) (actual time=0.003..0.003 rows=0 loops=10)
              Index Cond: (id = m.genre_id)
              Filter: ((name)::text = 'Genre_5'::text)
              Rows Removed by Filter: 1
Planning Time: 0.189 ms
Execution Time: 0.090 ms
```

-- После добавления индексов
```sql
CREATE INDEX idx_movies_title ON cinema.Movies(title);
CREATE INDEX idx_schedules_movie_id ON cinema.Schedules(movie_id);
CREATE INDEX idx_tickets_schedule_id ON cinema.Tickets(schedule_id);
```



-- Запрос для проверки всех билетов на конкретный фильм
```sql
EXPLAIN ANALYZE
SELECT t.*
FROM cinema.Tickets t
         JOIN cinema.Schedules s ON t.schedule_id = s.id
         JOIN cinema.Movies m ON s.movie_id = m.id
WHERE m.title = 'Movie_50';

Nested Loop  (cost=4.63..19.96 rows=10 width=22) (actual time=0.038..0.086 rows=12 loops=1)
  ->  Nested Loop  (cost=4.35..16.18 rows=10 width=4) (actual time=0.024..0.053 rows=15 loops=1)
        ->  Seq Scan on movies m  (cost=0.00..3.25 rows=1 width=4) (actual time=0.008..0.011 rows=1 loops=1)
              Filter: ((title)::text = 'Movie_50'::text)
              Rows Removed by Filter: 99
        ->  Bitmap Heap Scan on schedules s  (cost=4.35..12.83 rows=10 width=8) (actual time=0.015..0.038 rows=15 loops=1)
              Recheck Cond: (movie_id = m.id)
              Heap Blocks: exact=8
              ->  Bitmap Index Scan on idx_schedules_movie_id  (cost=0.00..4.35 rows=10 width=0) (actual time=0.011..0.011 rows=15 loops=1)
                    Index Cond: (movie_id = m.id)
  ->  Index Scan using idx_tickets_schedule_id on tickets t  (cost=0.28..0.36 rows=2 width=22) (actual time=0.002..0.002 rows=1 loops=15)
        Index Cond: (schedule_id = s.id)
Planning Time: 0.403 ms
Execution Time: 0.107 ms

```

-- Список фильмов определенного жанра
```sql
EXPLAIN ANALYZE
SELECT m.*
FROM cinema.Movies m
         JOIN cinema.Genres g ON m.genre_id = g.id
WHERE g.name = 'Genre_5';

Nested Loop  (cost=0.16..12.55 rows=1 width=80) (actual time=0.061..0.095 rows=11 loops=1)
  ->  Seq Scan on movies m  (cost=0.00..3.00 rows=100 width=80) (actual time=0.007..0.013 rows=100 loops=1)
  ->  Memoize  (cost=0.16..0.66 rows=1 width=4) (actual time=0.001..0.001 rows=0 loops=100)
        Cache Key: m.genre_id
        Cache Mode: logical
        Hits: 90  Misses: 10  Evictions: 0  Overflows: 0  Memory Usage: 1kB
        ->  Index Scan using genres_pkey on genres g  (cost=0.15..0.65 rows=1 width=4) (actual time=0.005..0.005 rows=0 loops=10)
              Index Cond: (id = m.genre_id)
              Filter: ((name)::text = 'Genre_5'::text)
              Rows Removed by Filter: 1
Planning Time: 0.089 ms
Execution Time: 0.114 ms
```
