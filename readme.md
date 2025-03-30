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

