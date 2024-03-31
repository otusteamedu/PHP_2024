# Планы выполнения запросов без индексов для 10000 строк

## Выбор всех фильмов на сегодня
```
"Nested Loop  (cost=0.29..70.53 rows=5 width=20) (actual time=0.135..0.665 rows=2 loops=1)"
"  ->  Seq Scan on movies_sessions ms  (cost=0.00..29.00 rows=5 width=16) (actual time=0.122..0.644 rows=2 loops=1)"
"        Filter: ((scheduled_at)::date = (now())::date)"
"        Rows Removed by Filter: 998"
"  ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=24) (actual time=0.007..0.007 rows=1 loops=2)"
"        Index Cond: (id = ms.movie_id)"
"Planning Time: 0.318 ms"
"Execution Time: 0.694 ms"
```

## Подсчёт проданных билетов за неделю
```
"Aggregate  (cost=242.05..242.06 rows=1 width=8) (actual time=2.609..2.611 rows=1 loops=1)"
"  ->  Hash Join  (cost=41.56..241.92 rows=50 width=0) (actual time=0.702..2.595 rows=148 loops=1)"
"        Hash Cond: (t.session_id = ms.id)"
"        ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.010..0.872 rows=10000 loops=1)"
"        ->  Hash  (cost=41.50..41.50 rows=5 width=8) (actual time=0.645..0.645 rows=15 loops=1)"
"              Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"              ->  Seq Scan on movies_sessions ms  (cost=0.00..41.50 rows=5 width=8) (actual time=0.018..0.637 rows=15 loops=1)"
"                    Filter: (((scheduled_at)::date <= (now())::date) AND ((scheduled_at)::date >= ((now())::date - '7 days'::interval)))"
"                    Rows Removed by Filter: 985"
"Planning Time: 0.411 ms"
"Execution Time: 2.649 ms"
```

## Формирование афиши (фильмы, которые показывают сегодня)
```
"Sort  (cost=281.06..281.19 rows=50 width=24) (actual time=5.431..5.435 rows=27 loops=1)"
"  Sort Key: ms.scheduled_at"
"  Sort Method: quicksort  Memory: 27kB"
"  ->  Nested Loop  (cost=29.36..279.65 rows=50 width=24) (actual time=1.100..5.386 rows=27 loops=1)"
"        ->  Hash Join  (cost=29.06..229.42 rows=50 width=16) (actual time=0.834..4.823 rows=27 loops=1)"
"              Hash Cond: (t.session_id = ms.id)"
"              ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=8) (actual time=0.010..1.594 rows=10000 loops=1)"
"              ->  Hash  (cost=29.00..29.00 rows=5 width=24) (actual time=0.631..0.631 rows=2 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"                    ->  Seq Scan on movies_sessions ms  (cost=0.00..29.00 rows=5 width=24) (actual time=0.116..0.624 rows=2 loops=1)"
"                          Filter: ((scheduled_at)::date = (now())::date)"
"                          Rows Removed by Filter: 998"
"        ->  Memoize  (cost=0.30..8.31 rows=1 width=24) (actual time=0.020..0.020 rows=1 loops=27)"
"              Cache Key: ms.movie_id"
"              Cache Mode: logical"
"              Hits: 25  Misses: 2  Evictions: 0  Overflows: 0  Memory Usage: 1kB"
"              ->  Index Scan using movies_pkey on movies m  (cost=0.29..8.30 rows=1 width=24) (actual time=0.259..0.260 rows=1 loops=2)"
"                    Index Cond: (id = ms.movie_id)"
"Planning Time: 0.668 ms"
"Execution Time: 5.504 ms"
```

## Поиск 3 самых прибыльных фильмов
```
"Limit  (cost=993.01..993.01 rows=3 width=32) (actual time=44.940..44.942 rows=3 loops=1)"
"  ->  Sort  (cost=993.01..1017.99 rows=9992 width=32) (actual time=44.939..44.940 rows=3 loops=1)"
"        Sort Key: (sum(t.price)) DESC"
"        Sort Method: top-N heapsort  Memory: 25kB"
"        ->  HashAggregate  (cost=763.94..863.86 rows=9992 width=32) (actual time=44.689..44.826 rows=956 loops=1)"
"              Group Key: m.id"
"              Batches: 1  Memory Usage: 529kB"
"              ->  Hash Join  (cost=487.32..713.94 rows=10000 width=32) (actual time=8.456..39.272 rows=10000 loops=1)"
"                    Hash Cond: (ms.movie_id = m.id)"
"                    ->  Hash Join  (cost=31.50..231.86 rows=10000 width=16) (actual time=0.939..13.794 rows=10000 loops=1)"
"                          Hash Cond: (t.session_id = ms.id)"
"                          ->  Seq Scan on tickets t  (cost=0.00..174.00 rows=10000 width=16) (actual time=0.247..3.665 rows=10000 loops=1)"
"                          ->  Hash  (cost=19.00..19.00 rows=1000 width=16) (actual time=0.677..0.677 rows=1000 loops=1)"
"                                Buckets: 1024  Batches: 1  Memory Usage: 55kB"
"                                ->  Seq Scan on movies_sessions ms  (cost=0.00..19.00 rows=1000 width=16) (actual time=0.010..0.435 rows=1000 loops=1)"
"                    ->  Hash  (cost=330.92..330.92 rows=9992 width=24) (actual time=7.479..7.480 rows=10000 loops=1)"
"                          Buckets: 16384  Batches: 1  Memory Usage: 681kB"
"                          ->  Seq Scan on movies m  (cost=0.00..330.92 rows=9992 width=24) (actual time=0.180..4.349 rows=10000 loops=1)"
"Planning Time: 6.664 ms"
"Execution Time: 45.107 ms"
```

## Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
```
Nested Loop Left Join  (cost=209.19..481.56 rows=100 width=32) (actual time=6.842..6.892 rows=100 loops=1)
   Join Filter: (s.id = sold_places.seat_id)
   Rows Removed by Join Filter: 99
   ->  Sort  (cost=200.61..200.86 rows=100 width=24) (actual time=4.120..4.126 rows=100 loops=1)
         Sort Key: s.row_number, s.seat_number
         Sort Method: quicksort  Memory: 31kB
         InitPlan 1 (returns $0)
           ->  Index Scan using movies_sessions_pkey on movies_sessions ms  (cost=0.28..8.29 rows=1 width=8) (actual time=0.444..0.446 rows=1 loops=1)
                 Index Cond: (id = 5)
         ->  Seq Scan on seats s  (cost=0.00..189.00 rows=100 width=24) (actual time=3.278..4.019 rows=100 loops=1)
               Filter: (hall_id = $0)
               Rows Removed by Filter: 9900
   ->  Materialize  (cost=8.58..278.20 rows=1 width=8) (actual time=0.022..0.027 rows=1 loops=100)
         ->  Subquery Scan on sold_places  (cost=8.58..278.20 rows=1 width=8) (actual time=2.231..2.707 rows=1 loops=1)
               ->  Nested Loop  (cost=8.58..278.19 rows=1 width=16) (actual time=2.230..2.706 rows=1 loops=1)
                     InitPlan 2 (returns $1)
                       ->  Index Scan using movies_sessions_pkey on movies_sessions ms_1  (cost=0.28..8.29 rows=1 width=8) (actual time=0.009..0.010 rows=1 loops=1)
                             Index Cond: (id = 5)
                     ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=9 width=16) (actual time=0.162..1.633 rows=11 loops=1)
                           Filter: (session_id = 5)
                           Rows Removed by Filter: 9989
                     ->  Index Scan using seats_pkey on seats s_1  (cost=0.29..7.86 rows=1 width=8) (actual time=0.096..0.096 rows=0 loops=11)
                           Index Cond: (id = t.seat_id)
                           Filter: (hall_id = $1)
                           Rows Removed by Filter: 1
 Planning Time: 5.394 ms
 Execution Time: 6.977 ms
```

## Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
```
Nested Loop  (cost=0.00..399.58 rows=9 width=24) (actual time=3.825..3.826 rows=1 loops=1)
   Join Filter: (t.session_id = t_1.session_id)
   ->  GroupAggregate  (cost=0.00..199.14 rows=9 width=16) (actual time=2.495..2.495 rows=1 loops=1)
         Group Key: t.session_id
         ->  Seq Scan on tickets t  (cost=0.00..199.00 rows=9 width=16) (actual time=1.277..2.485 rows=2 loops=1)
               Filter: (session_id = 2)
               Rows Removed by Filter: 9998
   ->  Materialize  (cost=0.00..199.27 rows=9 width=16) (actual time=1.328..1.328 rows=1 loops=1)
         ->  GroupAggregate  (cost=0.00..199.14 rows=9 width=16) (actual time=1.317..1.317 rows=1 loops=1)
               Group Key: t_1.session_id
               ->  Seq Scan on tickets t_1  (cost=0.00..199.00 rows=9 width=16) (actual time=0.228..1.310 rows=2 loops=1)
                     Filter: (session_id = 2)
                     Rows Removed by Filter: 9998
 Planning Time: 6.014 ms
 Execution Time: 3.903 ms
```
