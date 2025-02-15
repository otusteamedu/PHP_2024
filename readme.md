## Случайные даты:
	•	10 жанров,
	•	3 типа фильмов,
	•	100 режиссёров,
	•	500 актёров,
	•	10 000 фильмов с рандомными значениями.



```sql
Hash Join  (cost=41.00..415.18 rows=3936 width=147) (actual time=1.392..1.394 rows=0 loops=1)
  Hash Cond: (m.type_id = mt.id)
  InitPlan 1 (returns $0)
    ->  Limit  (cost=15.60..15.60 rows=1 width=12) (actual time=0.017..0.018 rows=1 loops=1)
          ->  Sort  (cost=15.60..16.40 rows=320 width=12) (actual time=0.016..0.016 rows=1 loops=1)
                Sort Key: (random())
                Sort Method: top-N heapsort  Memory: 25kB
                ->  Seq Scan on genres  (cost=0.00..14.00 rows=320 width=12) (actual time=0.005..0.006 rows=10 loops=1)
  ->  Hash Join  (cost=3.25..367.02 rows=3936 width=33) (actual time=1.391..1.392 rows=0 loops=1)
        Hash Cond: (m.director_id = d.id)
