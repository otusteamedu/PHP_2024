## Случайные данные:
	•	10 жанров,
	•	3 типа фильмов,
	•	100 режиссёров,
	•	500 актёров,
	•	10 000 фильмов с рандомными значениями.

-- Запрос для проверки
```sql
SELECT
    m.id, m.title, m.release_date, d.name AS director, mt.type_name AS movie_type
FROM LoadTesting.Movies m
         JOIN LoadTesting.Directors d ON m.director_id = d.id
         JOIN LoadTesting.MovieTypes mt ON m.type_id = mt.id
```
---

```sql
-- Запрос на 10 тысяч
Hash Join  (cost=25.40..332.22 rows=10000 width=147) (actual time=0.109..6.594 rows=10000 loops=1)
  Hash Cond: (m.type_id = mt.id)
  ->  Hash Join  (cost=3.25..283.61 rows=10000 width=33) (actual time=0.094..4.168 rows=10000 loops=1)
        Hash Cond: (m.director_id = d.id)
        ->  Seq Scan on movies m  (cost=0.00..253.00 rows=10000 width=26) (actual time=0.021..1.212 rows=10000 loops=1)
        ->  Hash  (cost=2.00..2.00 rows=100 width=15) (actual time=0.055..0.056 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on directors d  (cost=0.00..2.00 rows=100 width=15) (actual time=0.014..0.028 rows=100 loops=1)
  ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.009..0.010 rows=3 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB

---- После добасление еще строк данных.

Hash Join  (cost=25.40..307689.92 rows=10000000 width=150) (actual time=11.233..4376.257 rows=10000000 loops=1)
  Hash Cond: (m.type_id = mt.id)
  ->  Hash Join  (cost=3.25..281211.75 rows=10000000 width=36) (actual time=11.198..2859.484 rows=10000000 loops=1)
        Hash Cond: (m.director_id = d.id)
        ->  Seq Scan on movies m  (cost=0.00..253846.00 rows=10000000 width=29) (actual time=0.442..913.635 rows=10000000 loops=1)
        ->  Hash  (cost=2.00..2.00 rows=100 width=15) (actual time=10.743..10.747 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on directors d  (cost=0.00..2.00 rows=100 width=15) (actual time=10.702..10.718 rows=100 loops=1)
  ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.016..0.016 rows=3 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB

----
Создал индексы:
CREATE INDEX idx_movies_director ON LoadTesting.Movies (director_id);
CREATE INDEX idx_movies_id ON LoadTesting.Movies (id);
----

Hash Join  (cost=25.40..307689.92 rows=10000000 width=150) (actual time=9.311..4444.159 rows=10000000 loops=1)
  Hash Cond: (m.type_id = mt.id)
  ->  Hash Join  (cost=3.25..281211.75 rows=10000000 width=36) (actual time=9.287..2925.135 rows=10000000 loops=1)
        Hash Cond: (m.director_id = d.id)
        ->  Seq Scan on movies m  (cost=0.00..253846.00 rows=10000000 width=29) (actual time=0.066..967.622 rows=10000000 loops=1)
        ->  Hash  (cost=2.00..2.00 rows=100 width=15) (actual time=9.212..9.215 rows=100 loops=1)
              Buckets: 1024  Batches: 1  Memory Usage: 13kB
              ->  Seq Scan on directors d  (cost=0.00..2.00 rows=100 width=15) (actual time=9.180..9.188 rows=100 loops=1)
  ->  Hash  (cost=15.40..15.40 rows=540 width=122) (actual time=0.017..0.018 rows=3 loops=1)
        Buckets: 1024  Batches: 1  Memory Usage: 9kB

----
Реальное выполнение запроса уменьшается в 2 раза
----
