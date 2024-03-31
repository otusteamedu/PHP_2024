# Планы выполнения запросов без индексов для 10000 строк

## Выбор всех фильмов на сегодня
```
"Nested Loop  (cost=0.43..696.75 rows=50 width=20) (actual time=0.170..6.581 rows=22 loops=1)"
"  ->  Seq Scan on movies_sessions ms  (cost=0.00..274.00 rows=50 width=16) (actual time=0.153..6.327 rows=22 loops=1)"
"        Filter: ((scheduled_at)::date = (now())::date)"
"        Rows Removed by Filter: 9978"
"  ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=24) (actual time=0.010..0.010 rows=1 loops=22)"
"        Index Cond: (id = ms.movie_id)"
"Planning Time: 0.697 ms"
"Execution Time: 6.615 ms"
```

## Подсчёт проданных билетов за неделю
```
"Finalize Aggregate  (cost=127591.15..127591.16 rows=1 width=8) (actual time=401.727..402.581 rows=1 loops=1)"
"  ->  Gather  (cost=127590.93..127591.14 rows=2 width=8) (actual time=401.641..402.577 rows=3 loops=1)"
"        Workers Planned: 2"
"        Workers Launched: 2"
"        ->  Partial Aggregate  (cost=126590.93..126590.94 rows=1 width=8) (actual time=386.543..386.544 rows=1 loops=3)"
"              ->  Hash Join  (cost=399.62..126538.85 rows=20833 width=0) (actual time=4.893..384.783 rows=66605 loops=3)"
"                    Hash Cond: (t.session_id = ms.id)"
"                    ->  Parallel Seq Scan on tickets t  (cost=0.00..115197.00 rows=4166700 width=8) (actual time=0.074..186.869 rows=3333333 loops=3)"
"                    ->  Hash  (cost=399.00..399.00 rows=50 width=8) (actual time=4.754..4.754 rows=200 loops=3)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 16kB"
"                          ->  Seq Scan on movies_sessions ms  (cost=0.00..399.00 rows=50 width=8) (actual time=0.020..4.721 rows=200 loops=3)"
"                                Filter: (((scheduled_at)::date <= (now())::date) AND ((scheduled_at)::date >= ((now())::date - '7 days'::interval)))"
"                                Rows Removed by Filter: 9800"
"Planning Time: 0.313 ms"
"Execution Time: 402.612 ms"
```

## Формирование афиши (фильмы, которые показывают сегодня)
```
"Gather Merge  (cost=129860.16..134721.54 rows=41666 width=24) (actual time=392.053..394.312 rows=22025 loops=1)"
"  Workers Planned: 2"
"  Workers Launched: 2"
"  ->  Sort  (cost=128860.14..128912.22 rows=20833 width=24) (actual time=381.319..381.543 rows=7342 loops=3)"
"        Sort Key: ms.scheduled_at"
"        Sort Method: quicksort  Memory: 695kB"
"        Worker 0:  Sort Method: quicksort  Memory: 684kB"
"        Worker 1:  Sort Method: quicksort  Memory: 685kB"
"        ->  Nested Loop  (cost=275.07..127365.73 rows=20833 width=24) (actual time=5.371..379.971 rows=7342 loops=3)"
"              ->  Hash Join  (cost=274.62..126413.85 rows=20833 width=16) (actual time=5.137..377.260 rows=7342 loops=3)"
"                    Hash Cond: (t.session_id = ms.id)"
"                    ->  Parallel Seq Scan on tickets t  (cost=0.00..115197.00 rows=4166700 width=8) (actual time=0.080..192.926 rows=3333333 loops=3)"
"                    ->  Hash  (cost=274.00..274.00 rows=50 width=24) (actual time=4.082..4.082 rows=22 loops=3)"
"                          Buckets: 1024  Batches: 1  Memory Usage: 10kB"
"                          ->  Seq Scan on movies_sessions ms  (cost=0.00..274.00 rows=50 width=24) (actual time=0.173..4.044 rows=22 loops=3)"
"                                Filter: ((scheduled_at)::date = (now())::date)"
"                                Rows Removed by Filter: 9978"
"              ->  Memoize  (cost=0.45..8.46 rows=1 width=24) (actual time=0.000..0.000 rows=1 loops=22025)"
"                    Cache Key: ms.movie_id"
"                    Cache Mode: logical"
"                    Hits: 7431  Misses: 22  Evictions: 0  Overflows: 0  Memory Usage: 3kB"
"                    Worker 0:  Hits: 7255  Misses: 22  Evictions: 0  Overflows: 0  Memory Usage: 3kB"
"                    Worker 1:  Hits: 7273  Misses: 22  Evictions: 0  Overflows: 0  Memory Usage: 3kB"
"                    ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=24) (actual time=0.019..0.019 rows=1 loops=66)"
"                          Index Cond: (id = ms.movie_id)"
"Planning Time: 0.549 ms"
"Execution Time: 394.946 ms"
```

## Поиск 3 самых прибыльных фильмов
```
"Limit  (cost=1551681.40..1551681.41 rows=3 width=32) (actual time=3759.474..3759.475 rows=3 loops=1)"
"  ->  Sort  (cost=1551681.40..1576680.55 rows=9999658 width=32) (actual time=3759.473..3759.474 rows=3 loops=1)"
"        Sort Key: (sum(t.price)) DESC"
"        Sort Method: top-N heapsort  Memory: 25kB"
"        ->  HashAggregate  (cost=1185721.28..1422437.70 rows=9999658 width=32) (actual time=3757.864..3758.673 rows=9991 loops=1)"
"              Group Key: m.id"
"              Planned Partitions: 256  Batches: 1  Memory Usage: 2833kB"
"              ->  Hash Join  (cost=77808.00..388839.90 rows=10000080 width=32) (actual time=75.294..2188.537 rows=10000000 loops=1)"
"                    Hash Cond: (t.session_id = ms.id)"
"                    ->  Seq Scan on tickets t  (cost=0.00..173530.80 rows=10000080 width=16) (actual time=0.037..459.026 rows=10000000 loops=1)"
"                    ->  Hash  (cost=77683.00..77683.00 rows=10000 width=32) (actual time=75.249..75.249 rows=10000 loops=1)"
"                          Buckets: 16384  Batches: 1  Memory Usage: 794kB"
"                          ->  Nested Loop  (cost=0.43..77683.00 rows=10000 width=32) (actual time=0.024..73.051 rows=10000 loops=1)"
"                                ->  Seq Scan on movies_sessions ms  (cost=0.00..174.00 rows=10000 width=16) (actual time=0.004..0.720 rows=10000 loops=1)"
"                                ->  Index Scan using movies_pkey on movies m  (cost=0.43..7.75 rows=1 width=24) (actual time=0.007..0.007 rows=1 loops=10000)"
"                                      Index Cond: (id = ms.movie_id)"
"Planning Time: 0.442 ms"
"Execution Time: 3759.811 ms"
```

## Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
```
Hash Right Join  (cost=1211.72..127597.77 rows=100 width=32) (actual time=17.278..177.580 rows=100 loops=1)
   Hash Cond: (t.seat_id = s_1.id)
   ->  Nested Loop  (cost=1008.60..127394.50 rows=10 width=16) (actual time=14.837..175.113 rows=12 loops=1)
         InitPlan 2 (returns $1)
           ->  Index Scan using movies_sessions_pkey on movies_sessions ms_1  (cost=0.29..8.30 rows=1 width=8) (actual time=0.014..0.016 rows=1 loops=1)
                 Index Cond: (id = 5)
         ->  Gather  (cost=1000.00..126713.55 rows=998 width=16) (actual time=2.416..172.844 rows=1006 loops=1)
               Workers Planned: 2
               Workers Launched: 2
               ->  Parallel Seq Scan on tickets t  (cost=0.00..125613.75 rows=416 width=16) (actual time=2.699..166.212 rows=335 loops=3)
                     Filter: (session_id = 5)
                     Rows Removed by Filter: 3332998
         ->  Memoize  (cost=0.30..0.69 rows=1 width=8) (actual time=0.002..0.002 rows=0 loops=1006)
               Cache Key: t.seat_id
               Cache Mode: logical
               Hits: 48  Misses: 958  Evictions: 0  Overflows: 0  Memory Usage: 68kB
               ->  Index Scan using seats_pkey on seats s  (cost=0.29..0.68 rows=1 width=8) (actual time=0.002..0.002 rows=0 loops=958)
                     Index Cond: (id = t.seat_id)
                     Filter: (hall_id = $1)
                     Rows Removed by Filter: 1
   ->  Hash  (cost=201.87..201.87 rows=100 width=24) (actual time=2.426..2.427 rows=100 loops=1)
         Buckets: 1024  Batches: 1  Memory Usage: 14kB
         ->  Sort  (cost=200.62..200.87 rows=100 width=24) (actual time=2.373..2.386 rows=100 loops=1)
               Sort Key: s_1.row_number, s_1.seat_number
               Sort Method: quicksort  Memory: 31kB
               InitPlan 1 (returns $0)
                 ->  Index Scan using movies_sessions_pkey on movies_sessions ms  (cost=0.29..8.30 rows=1 width=8) (actual time=0.051..0.052 rows=1 loops=1)
                       Index Cond: (id = 5)
               ->  Seq Scan on seats s_1  (cost=0.00..189.00 rows=100 width=24) (actual time=0.375..2.278 rows=100 loops=1)
                     Filter: (hall_id = $0)
                     Rows Removed by Filter: 9900
 Planning Time: 3.477 ms
 Execution Time: 177.849 ms
```

## Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
```
"Hash Join  (cost=127738.22..253467.12 rows=4512 width=24) (actual time=380.502..381.997 rows=1 loops=1)"
"  Hash Cond: (t.session_id = t_1.session_id)"
"  ->  Finalize GroupAggregate  (cost=1000.00..126716.85 rows=950 width=16) (actual time=213.619..213.646 rows=1 loops=1)"
"        Group Key: t.session_id"
"        ->  Gather  (cost=1000.00..126703.19 rows=832 width=16) (actual time=213.541..213.640 rows=3 loops=1)"
"              Workers Planned: 2"
"              Workers Launched: 2"
"              ->  Partial GroupAggregate  (cost=0.00..125619.99 rows=416 width=16) (actual time=199.383..199.383 rows=1 loops=3)"
"                    Group Key: t.session_id"
"                    ->  Parallel Seq Scan on tickets t  (cost=0.00..125613.75 rows=416 width=16) (actual time=4.141..199.261 rows=182 loops=3)"
"                          Filter: (session_id = 2)"
"                          Rows Removed by Filter: 3333151"
"  ->  Hash  (cost=126726.35..126726.35 rows=950 width=16) (actual time=166.874..168.340 rows=1 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  Finalize GroupAggregate  (cost=1000.00..126716.85 rows=950 width=16) (actual time=166.867..168.334 rows=1 loops=1)"
"              Group Key: t_1.session_id"
"              ->  Gather  (cost=1000.00..126703.19 rows=832 width=16) (actual time=166.804..168.329 rows=3 loops=1)"
"                    Workers Planned: 2"
"                    Workers Launched: 2"
"                    ->  Partial GroupAggregate  (cost=0.00..125619.99 rows=416 width=16) (actual time=164.232..164.232 rows=1 loops=3)"
"                          Group Key: t_1.session_id"
"                          ->  Parallel Seq Scan on tickets t_1  (cost=0.00..125613.75 rows=416 width=16) (actual time=0.841..164.169 rows=182 loops=3)"
"                                Filter: (session_id = 2)"
"                                Rows Removed by Filter: 3333151"
"Planning Time: 0.359 ms"
"Execution Time: 382.121 ms"
```
