## Случайные данные:
genres,30
halls,120
movieactors,494288
movies,10100
schedules,101000
tickets,101000


-- Запрос для проверки всех билетов на конкретный фильм
```sql
EXPLAIN ANALYZE
SELECT t.*
FROM cinema.Tickets t
         JOIN cinema.Schedules s ON t.schedule_id = s.id
         JOIN cinema.Movies m ON s.movie_id = m.id
WHERE m.title = 'Movie_50';

Hash Join  (cost=2299.76..4332.71 rows=20 width=22) (actual time=12.645..23.574 rows=51 loops=1)
  Hash Cond: (t.schedule_id = s.id)
  ->  Seq Scan on tickets t  (cost=0.00..1654.00 rows=101000 width=22) (actual time=0.011..5.452 rows=101000 loops=1)
  ->  Hash  (cost=2299.51..2299.51 rows=20 width=4) (actual time=12.620..12.622 rows=39 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 10kB
        ->  Hash Join  (cost=281.27..2299.51 rows=20 width=4) (actual time=0.622..12.603 rows=39 loops=1)
              Hash Cond: (s.movie_id = m.id)
              ->  Seq Scan on schedules s  (cost=0.00..1753.00 rows=101000 width=8) (actual time=0.008..6.099 rows=101000 loops=1)
              ->  Hash  (cost=281.25..281.25 rows=2 width=4) (actual time=0.595..0.596 rows=2 loops=1)
                    Buckets: 1024  Batches: 1  Memory Usage: 9kB
                    ->  Seq Scan on movies m  (cost=0.00..281.25 rows=2 width=4) (actual time=0.007..0.593 rows=2 loops=1)
                          Filter: ((title)::text = 'Movie_50'::text)
                          Rows Removed by Filter: 10098
Planning Time: 0.505 ms
Execution Time: 23.600 ms
```

-- Список фильмов определенного жанра
```sql
EXPLAIN ANALYZE
SELECT m.*
FROM cinema.Movies m
         JOIN cinema.Genres g ON m.genre_id = g.id
WHERE g.name = 'Genre_5';

Hash Join  (cost=14.03..296.89 rows=63 width=84) (actual time=0.210..1.699 rows=1134 loops=1)
  Hash Cond: (m.genre_id = g.id)
  ->  Seq Scan on movies m  (cost=0.00..256.00 rows=10100 width=84) (actual time=0.007..0.582 rows=10100 loops=1)
  ->  Hash  (cost=14.00..14.00 rows=2 width=4) (actual time=0.197..0.197 rows=3 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on genres g  (cost=0.00..14.00 rows=2 width=4) (actual time=0.191..0.193 rows=3 loops=1)
              Filter: ((name)::text = 'Genre_5'::text)
              Rows Removed by Filter: 27
Planning Time: 0.576 ms
Execution Time: 1.751 ms
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

Nested Loop  (cost=4.95..99.62 rows=20 width=22) (actual time=0.038..0.250 rows=51 loops=1)
  ->  Nested Loop  (cost=4.66..91.97 rows=20 width=4) (actual time=0.030..0.083 rows=39 loops=1)
        ->  Index Scan using idx_movies_title on movies m  (cost=0.29..9.74 rows=2 width=4) (actual time=0.018..0.019 rows=2 loops=1)
              Index Cond: ((title)::text = 'Movie_50'::text)
        ->  Bitmap Heap Scan on schedules s  (cost=4.37..41.01 rows=10 width=8) (actual time=0.011..0.028 rows=20 loops=2)
              Recheck Cond: (movie_id = m.id)
              Heap Blocks: exact=32
              ->  Bitmap Index Scan on idx_schedules_movie_id  (cost=0.00..4.37 rows=10 width=0) (actual time=0.006..0.006 rows=20 loops=2)
                    Index Cond: (movie_id = m.id)
  ->  Index Scan using idx_tickets_schedule_id on tickets t  (cost=0.29..0.36 rows=2 width=22) (actual time=0.003..0.004 rows=1 loops=39)
        Index Cond: (schedule_id = s.id)
Planning Time: 0.501 ms
Execution Time: 0.280 ms
```

-- Список фильмов определенного жанра
```sql
EXPLAIN ANALYZE
SELECT m.*
FROM cinema.Movies m
         JOIN cinema.Genres g ON m.genre_id = g.id
WHERE g.name = 'Genre_5';

Hash Join  (cost=14.03..296.89 rows=63 width=84) (actual time=0.021..1.436 rows=1134 loops=1)
  Hash Cond: (m.genre_id = g.id)
  ->  Seq Scan on movies m  (cost=0.00..256.00 rows=10100 width=84) (actual time=0.006..0.562 rows=10100 loops=1)
  ->  Hash  (cost=14.00..14.00 rows=2 width=4) (actual time=0.010..0.011 rows=3 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB
        ->  Seq Scan on genres g  (cost=0.00..14.00 rows=2 width=4) (actual time=0.006..0.008 rows=3 loops=1)
              Filter: ((name)::text = 'Genre_5'::text)
              Rows Removed by Filter: 27
Planning Time: 0.087 ms
Execution Time: 1.486 ms
```
