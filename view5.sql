--Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
SELECT p.row, p.col, t.paid AS busy
FROM tbl_show s
INNER JOIN tbl_ticket t ON t.show_id = s.id
INNER JOIN tbl_place p ON p.id = t.place_id
WHERE s.id = 3
ORDER BY p."row" ASC, p.col ASC;

/**
Sort  (cost=205.71..205.73 rows=9 width=9) (actual time=0.850..0.851 rows=9 loops=1)
  Sort Key: p."row", p.col
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=0.43..205.57 rows=9 width=9) (actual time=0.100..0.824 rows=9 loops=1)
        ->  Nested Loop  (cost=0.28..168.03 rows=9 width=5) (actual time=0.074..0.788 rows=9 loops=1)
              ->  Index Only Scan using tbl_show_pkey on tbl_show s  (cost=0.28..8.29 rows=1 width=4) (actual time=0.046..0.047 rows=1 loops=1)
                    Index Cond: (id = 3)
                    Heap Fetches: 1
              ->  Seq Scan on tbl_ticket t  (cost=0.00..159.65 rows=9 width=9) (actual time=0.027..0.738 rows=9 loops=1)
                    Filter: (show_id = 3)
                    Rows Removed by Filter: 7803
        ->  Index Scan using tbl_place_pkey on tbl_place p  (cost=0.15..4.17 rows=1 width=12) (actual time=0.002..0.002 rows=1 loops=9)
              Index Cond: (id = t.place_id)
Planning Time: 0.258 ms
Execution Time: 0.997 ms

добавил индекс tbl_ticket_show_id_idx
Sort  (cost=54.50..54.52 rows=9 width=9) (actual time=0.048..0.049 rows=9 loops=1)
  Sort Key: p."row", p.col
  Sort Method: quicksort  Memory: 25kB
  ->  Nested Loop  (cost=0.71..54.36 rows=9 width=9) (actual time=0.025..0.040 rows=9 loops=1)
        ->  Nested Loop  (cost=0.56..16.82 rows=9 width=5) (actual time=0.020..0.025 rows=9 loops=1)
              ->  Index Only Scan using tbl_show_pkey on tbl_show s  (cost=0.28..8.29 rows=1 width=4) (actual time=0.010..0.011 rows=1 loops=1)
                    Index Cond: (id = 3)
                    Heap Fetches: 1
              ->  Index Scan using tbl_ticket_show_id_idx on tbl_ticket t  (cost=0.28..8.44 rows=9 width=9) (actual time=0.007..0.009 rows=9 loops=1)
                    Index Cond: (show_id = 3)
        ->  Index Scan using tbl_place_pkey on tbl_place p  (cost=0.15..4.17 rows=1 width=12) (actual time=0.001..0.001 rows=1 loops=9)
              Index Cond: (id = t.place_id)
Planning Time: 0.480 ms
Execution Time: 0.113 ms

*/