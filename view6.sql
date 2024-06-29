--Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
SELECT min(t.price), max(t.price)
FROM tbl_show s
LEFT JOIN tbl_price t ON t.show_id  = s.id
WHERE s.id = 3

/**
около 10000 тысячь записей
Aggregate  (cost=156.06..156.07 rows=1 width=16) (actual time=0.549..0.550 rows=1 loops=1)
  ->  Nested Loop Left Join  (cost=0.28..156.06 rows=1 width=8) (actual time=0.014..0.545 rows=9 loops=1)
        Join Filter: (t.show_id = s.id)
        ->  Index Only Scan using tbl_show_pkey on tbl_show s  (cost=0.28..8.29 rows=1 width=4) (actual time=0.007..0.008 rows=1 loops=1)
              Index Cond: (id = 3)
              Heap Fetches: 1
        ->  Seq Scan on tbl_price t  (cost=0.00..147.65 rows=9 width=12) (actual time=0.006..0.535 rows=9 loops=1)
              Filter: (show_id = 3)
              Rows Removed by Filter: 7803
Planning Time: 0.129 ms
Execution Time: 0.570 ms

добавил индекс tbl_price_show_id_idx и  tbl_price_price_idx запрос выглядит оптимальным
Aggregate  (cost=16.85..16.86 rows=1 width=16) (actual time=0.024..0.025 rows=1 loops=1)
  ->  Nested Loop Left Join  (cost=0.56..16.84 rows=1 width=8) (actual time=0.017..0.021 rows=9 loops=1)
        Join Filter: (t.show_id = s.id)
        ->  Index Only Scan using tbl_show_pkey on tbl_show s  (cost=0.28..8.29 rows=1 width=4) (actual time=0.009..0.009 rows=1 loops=1)
              Index Cond: (id = 3)
              Heap Fetches: 1
        ->  Index Scan using tbl_price_show_id_idx on tbl_price t  (cost=0.28..8.44 rows=9 width=12) (actual time=0.005..0.007 rows=9 loops=1)
              Index Cond: (show_id = 3)
Planning Time: 0.720 ms
Execution Time: 0.052 ms


7000 тысячь записей запрос оптимален
Aggregate  (cost=195.26..195.27 rows=1 width=16) (actual time=0.962..0.963 rows=1 loops=1)
  ->  Nested Loop Left Join  (cost=5.10..195.26 rows=1 width=8) (actual time=0.891..0.956 rows=48 loops=1)
        Join Filter: (t.show_id = s.id)
        ->  Index Only Scan using tbl_show_pkey on tbl_show s  (cost=0.29..4.30 rows=1 width=4) (actual time=0.008..0.009 rows=1 loops=1)
              Index Cond: (id = 3)
              Heap Fetches: 0
        ->  Bitmap Heap Scan on tbl_price t  (cost=4.81..190.33 rows=50 width=12) (actual time=0.877..0.935 rows=48 loops=1)
              Recheck Cond: (show_id = 3)
              Heap Blocks: exact=48
              ->  Bitmap Index Scan on tbl_price_show_id_idx  (cost=0.00..4.80 rows=50 width=0) (actual time=0.868..0.868 rows=48 loops=1)
                    Index Cond: (show_id = 3)
Planning Time: 2.825 ms
Execution Time: 1.017 ms
*/