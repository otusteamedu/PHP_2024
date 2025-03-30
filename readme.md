## Случайные данные:
	•	8 жанров,
	•	4 типа фильмов,
	•	4 режиссёров,
	•	26 актёров,
	•	1020 фильмов с рандомными значениями.

-- Запрос для проверки
```sql
EXPLAIN ANALYZE
SELECT m.title, d.name AS director_name
FROM Movies m
JOIN Directors d ON m.director_id = d.id
WHERE m.release_date > '2000-01-01';

Nested Loop  (cost=0.15..40.04 rows=281 width=525) (actual time=0.019..0.171 rows=280 loops=1)
  ->  Seq Scan on movies m  (cost=0.00..27.75 rows=281 width=13) (actual time=0.010..0.082 rows=280 loops=1)
        Filter: (release_date > '2000-01-01'::date)
        Rows Removed by Filter: 740
  ->  Memoize  (cost=0.15..0.34 rows=1 width=520) (actual time=0.000..0.000 rows=1 loops=280)
        Cache Key: m.director_id
        Cache Mode: logical
        Hits: 265  Misses: 15  Evictions: 0  Overflows: 0  Memory Usage: 2kB
        ->  Index Scan using directors_pkey on directors d  (cost=0.14..0.33 rows=1 width=520) (actual time=0.001..0.001 rows=1 loops=15)
              Index Cond: (id = m.director_id)
Planning Time: 0.198 ms
Execution Time: 0.202 ms
```

```sql
EXPLAIN ANALYZE
SELECT *
FROM Movies
ORDER BY release_date DESC
LIMIT 100;

Limit  (cost=64.18..64.43 rows=100 width=82) (actual time=0.175..0.184 rows=100 loops=1)
  ->  Sort  (cost=64.18..66.73 rows=1020 width=82) (actual time=0.174..0.178 rows=100 loops=1)
        Sort Key: release_date DESC
        Sort Method: top-N heapsort  Memory: 45kB
        ->  Seq Scan on movies  (cost=0.00..25.20 rows=1020 width=82) (actual time=0.004..0.063 rows=1020 loops=1)
Planning Time: 0.058 ms
Execution Time: 0.197 ms
```

```sql
EXPLAIN ANALYZE
SELECT title, release_date
FROM Movies
WHERE release_date = (
    SELECT MAX(release_date)
    FROM Movies
);

Seq Scan on movies  (cost=27.76..55.51 rows=1 width=13) (actual time=0.122..0.173 rows=1 loops=1)
  Filter: (release_date = $0)
  Rows Removed by Filter: 1019
  InitPlan 1 (returns $0)
    ->  Aggregate  (cost=27.75..27.76 rows=1 width=4) (actual time=0.114..0.115 rows=1 loops=1)
          ->  Seq Scan on movies movies_1  (cost=0.00..25.20 rows=1020 width=4) (actual time=0.001..0.058 rows=1020 loops=1)
Planning Time: 0.094 ms
Execution Time: 0.190 ms
```

-- Полная сводка по БД
```sql
EXPLAIN ANALYZE
SELECT
    g.name AS genre_name,
    COUNT(DISTINCT m.id) AS total_movies_in_genre,
    ARRAY_AGG(DISTINCT d.name) AS directors_in_genre,
    COUNT(DISTINCT ma.actor_id) AS total_actors_in_genre,
    ARRAY_AGG(DISTINCT a.name) AS actors_in_genre,
    COUNT(s.id) AS total_schedules_in_genre,
    SUM(t.price) AS total_ticket_revenue_in_genre
FROM Genres g
         LEFT JOIN Movies m ON g.id = m.genre_id
         LEFT JOIN Directors d ON m.director_id = d.id
         LEFT JOIN MovieActors ma ON m.id = ma.movie_id
         LEFT JOIN Actors a ON ma.actor_id = a.id
         LEFT JOIN Schedules s ON m.id = s.movie_id
         LEFT JOIN Tickets t ON s.id = t.schedule_id
GROUP BY g.name
ORDER BY total_movies_in_genre DESC;


Sort  (cost=4666.60..4667.10 rows=200 width=338) (actual time=6.028..6.034 rows=8 loops=1)
  Sort Key: (count(DISTINCT m.id)) DESC
  Sort Method: quicksort  Memory: 28kB
  ->  GroupAggregate  (cost=4520.30..4658.96 rows=200 width=338) (actual time=4.817..6.025 rows=8 loops=1)
        Group Key: g.name
        ->  Sort  (cost=4520.30..4537.19 rows=6758 width=1268) (actual time=4.690..4.842 rows=3459 loops=1)
"              Sort Key: g.name, m.id"
              Sort Method: quicksort  Memory: 313kB
              ->  Hash Right Join  (cost=258.06..345.41 rows=6758 width=1268) (actual time=1.582..2.566 rows=3459 loops=1)
                    Hash Cond: (s.movie_id = m.id)
                    ->  Hash Right Join  (cost=91.62..96.15 rows=3050 width=14) (actual time=0.529..0.865 rows=3202 loops=1)
                          Hash Cond: (t.schedule_id = s.id)
                          ->  Seq Scan on tickets t  (cost=0.00..4.00 rows=200 width=10) (actual time=0.005..0.015 rows=200 loops=1)
                          ->  Hash  (cost=53.50..53.50 rows=3050 width=8) (actual time=0.516..0.517 rows=3050 loops=1)
                                Buckets: 4096  Batches: 1  Memory Usage: 152kB
                                ->  Seq Scan on schedules s  (cost=0.00..53.50 rows=3050 width=8) (actual time=0.006..0.219 rows=3050 loops=1)
                    ->  Hash  (cost=138.18..138.18 rows=2260 width=1258) (actual time=1.047..1.051 rows=1042 loops=1)
                          Buckets: 4096  Batches: 1  Memory Usage: 95kB
                          ->  Hash Left Join  (cost=81.45..138.18 rows=2260 width=1258) (actual time=0.314..0.908 rows=1042 loops=1)
                                Hash Cond: (ma.actor_id = a.id)
                                ->  Hash Left Join  (cost=68.30..118.98 rows=2260 width=742) (actual time=0.304..0.807 rows=1042 loops=1)
                                      Hash Cond: (m.director_id = d.id)
                                      ->  Hash Right Join  (cost=55.15..99.72 rows=2260 width=230) (actual time=0.293..0.666 rows=1042 loops=1)
                                            Hash Cond: (m.genre_id = g.id)
                                            ->  Hash Right Join  (cost=37.95..76.50 rows=2260 width=16) (actual time=0.274..0.519 rows=1042 loops=1)
                                                  Hash Cond: (ma.movie_id = m.id)
                                                  ->  Seq Scan on movieactors ma  (cost=0.00..32.60 rows=2260 width=8) (actual time=0.005..0.008 rows=40 loops=1)
                                                  ->  Hash  (cost=25.20..25.20 rows=1020 width=12) (actual time=0.251..0.252 rows=1020 loops=1)
                                                        Buckets: 1024  Batches: 1  Memory Usage: 52kB
                                                        ->  Seq Scan on movies m  (cost=0.00..25.20 rows=1020 width=12) (actual time=0.004..0.136 rows=1020 loops=1)
                                            ->  Hash  (cost=13.20..13.20 rows=320 width=222) (actual time=0.015..0.016 rows=8 loops=1)
                                                  Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                                  ->  Seq Scan on genres g  (cost=0.00..13.20 rows=320 width=222) (actual time=0.011..0.012 rows=8 loops=1)
                                      ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.007..0.007 rows=15 loops=1)
                                            Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                            ->  Seq Scan on directors d  (cost=0.00..11.40 rows=140 width=520) (actual time=0.004..0.005 rows=15 loops=1)
                                ->  Hash  (cost=11.40..11.40 rows=140 width=520) (actual time=0.007..0.008 rows=26 loops=1)
                                      Buckets: 1024  Batches: 1  Memory Usage: 10kB
                                      ->  Seq Scan on actors a  (cost=0.00..11.40 rows=140 width=520) (actual time=0.003..0.004 rows=26 loops=1)
Planning Time: 0.841 ms
Execution Time: 6.103 ms

```
