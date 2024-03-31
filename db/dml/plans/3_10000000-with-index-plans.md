# Планы выполнения запросов без индексов для 10000 строк

## Выбор всех фильмов на сегодня
```
С использованием CREATE INDEX movies_sessions_movie_id on movies_sessions (movie_id);

"Nested Loop  (cost=0.43..696.75 rows=50 width=20) (actual time=0.156..5.447 rows=22 loops=1)"
"  ->  Seq Scan on movies_sessions ms  (cost=0.00..274.00 rows=50 width=16) (actual time=0.140..4.760 rows=22 loops=1)"
"        Filter: ((scheduled_at)::date = (now())::date)"
"        Rows Removed by Filter: 9978"
"  ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=24) (actual time=0.030..0.030 rows=1 loops=22)"
"        Index Cond: (id = ms.movie_id)"
"Planning Time: 0.808 ms"
"Execution Time: 5.477 ms"
```

## Подсчёт проданных билетов за неделю
```
С использованием индекса CREATE INDEX tickets_sessions on tickets (session_id);

"Aggregate  (cost=2123.50..2123.51 rows=1 width=8) (actual time=34.879..34.880 rows=1 loops=1)"
"  ->  Nested Loop  (cost=0.43..1998.50 rows=50000 width=0) (actual time=0.018..27.422 rows=199815 loops=1)"
"        ->  Seq Scan on movies_sessions ms  (cost=0.00..399.00 rows=50 width=8) (actual time=0.010..2.694 rows=200 loops=1)"
"              Filter: (((scheduled_at)::date <= (now())::date) AND ((scheduled_at)::date >= ((now())::date - '7 days'::interval)))"
"              Rows Removed by Filter: 9800"
"        ->  Index Only Scan using tickets_sessions on tickets t  (cost=0.43..21.97 rows=1002 width=8) (actual time=0.008..0.064 rows=999 loops=200)"
"              Index Cond: (session_id = ms.id)"
"              Heap Fetches: 0"
"Planning Time: 0.776 ms"
"Execution Time: 34.906 ms"
```

## Формирование афиши (фильмы, которые показывают сегодня)
```
-- С использованием индекса CREATE INDEX tickets_sessions on tickets (session_id);

"Sort  (cost=6198.54..6323.54 rows=50000 width=24) (actual time=12.795..14.612 rows=22025 loops=1)"
"  Sort Key: ms.scheduled_at"
"  Sort Method: quicksort  Memory: 2255kB"
"  ->  Nested Loop  (cost=0.87..2296.13 rows=50000 width=24) (actual time=0.159..8.390 rows=22025 loops=1)"
"        ->  Nested Loop  (cost=0.43..696.63 rows=50 width=32) (actual time=0.151..3.151 rows=22 loops=1)"
"              ->  Seq Scan on movies_sessions ms  (cost=0.00..274.00 rows=50 width=24) (actual time=0.091..2.937 rows=22 loops=1)"
"                    Filter: ((scheduled_at)::date = (now())::date)"
"                    Rows Removed by Filter: 9978"
"              ->  Index Scan using movies_pkey on movies m  (cost=0.43..8.45 rows=1 width=24) (actual time=0.007..0.007 rows=1 loops=22)"
"                    Index Cond: (id = ms.movie_id)"
"        ->  Index Only Scan using tickets_sessions on tickets t  (cost=0.43..21.97 rows=1002 width=8) (actual time=0.006..0.128 rows=1001 loops=22)"
"              Index Cond: (session_id = ms.id)"
"              Heap Fetches: 0"
"Planning Time: 0.653 ms"
"Execution Time: 17.158 ms"
```

## Поиск 3 самых прибыльных фильмов
```
С использование индекса CREATE INDEX tickets_sessions_price on tickets (session_id, price);

"Limit  (cost=933299.04..933299.05 rows=3 width=32) (actual time=2235.218..2235.262 rows=3 loops=1)"
"  ->  Sort  (cost=933299.04..958298.19 rows=9999658 width=32) (actual time=2235.217..2235.260 rows=3 loops=1)"
"        Sort Key: (sum(t.price)) DESC"
"        Sort Method: top-N heapsort  Memory: 25kB"
"        ->  GroupAggregate  (cost=293950.53..804055.34 rows=9999658 width=32) (actual time=683.329..2233.462 rows=9991 loops=1)"
"              Group Key: m.id"
"              ->  Nested Loop  (cost=293950.53..654058.76 rows=10000000 width=32) (actual time=683.170..1934.661 rows=10000000 loops=1)"
"                    ->  Gather Merge  (cost=293950.09..295114.76 rows=10000 width=32) (actual time=683.153..685.642 rows=10000 loops=1)"
"                          Workers Planned: 2"
"                          Workers Launched: 2"
"                          ->  Sort  (cost=292950.07..292960.49 rows=4167 width=32) (actual time=673.498..673.669 rows=3333 loops=3)"
"                                Sort Key: m.id"
"                                Sort Method: quicksort  Memory: 340kB"
"                                Worker 0:  Sort Method: quicksort  Memory: 345kB"
"                                Worker 1:  Sort Method: quicksort  Memory: 348kB"
"                                ->  Hash Join  (cost=299.00..292699.53 rows=4167 width=32) (actual time=6.957..672.567 rows=3333 loops=3)"
"                                      Hash Cond: (m.id = ms.movie_id)"
"                                      ->  Parallel Seq Scan on movies m  (cost=0.00..271526.24 rows=4166524 width=24) (actual time=0.039..344.435 rows=3333333 loops=3)"
"                                      ->  Hash  (cost=174.00..174.00 rows=10000 width=16) (actual time=6.135..6.135 rows=10000 loops=3)"
"                                            Buckets: 16384  Batches: 1  Memory Usage: 597kB"
"                                            ->  Seq Scan on movies_sessions ms  (cost=0.00..174.00 rows=10000 width=16) (actual time=0.047..3.489 rows=10000 loops=3)"
"                    ->  Index Only Scan using tickets_sessions_price on tickets t  (cost=0.43..25.87 rows=1002 width=16) (actual time=0.007..0.084 rows=1000 loops=10000)"
"                          Index Cond: (session_id = ms.id)"
"                          Heap Fetches: 0"
"Planning Time: 2.170 ms"
"Execution Time: 2235.789 ms"
```

## Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс
```
С индексом CREATE INDEX ticket_seat_session_id on tickets (seat_id, session_id);

"Hash Right Join  (cost=211.86..847.07 rows=100 width=32) (actual time=1.285..2.822 rows=100 loops=1)"
"  Hash Cond: (t.seat_id = s_1.id)"
"  ->  Nested Loop  (cost=8.74..643.80 rows=10 width=16) (actual time=0.296..1.807 rows=12 loops=1)"
"        InitPlan 2 (returns $1)"
"          ->  Index Scan using movies_sessions_pkey on movies_sessions ms_1  (cost=0.29..8.30 rows=1 width=8) (actual time=0.003..0.004 rows=1 loops=1)"
"                Index Cond: (id = 5)"
"        ->  Seq Scan on seats s  (cost=0.00..189.00 rows=100 width=8) (actual time=0.123..0.925 rows=100 loops=1)"
"              Filter: (hall_id = $1)"
"              Rows Removed by Filter: 9900"
"        ->  Index Only Scan using ticket_seat_session_id on tickets t  (cost=0.43..4.45 rows=1 width=16) (actual time=0.008..0.009 rows=0 loops=100)"
"              Index Cond: ((seat_id = s.id) AND (session_id = 5))"
"              Heap Fetches: 0"
"  ->  Hash  (cost=201.87..201.87 rows=100 width=24) (actual time=0.983..0.984 rows=100 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 14kB"
"        ->  Sort  (cost=200.62..200.87 rows=100 width=24) (actual time=0.963..0.970 rows=100 loops=1)"
"              Sort Key: s_1.row_number, s_1.seat_number"
"              Sort Method: quicksort  Memory: 31kB"
"              InitPlan 1 (returns $0)"
"                ->  Index Scan using movies_sessions_pkey on movies_sessions ms  (cost=0.29..8.30 rows=1 width=8) (actual time=0.008..0.009 rows=1 loops=1)"
"                      Index Cond: (id = 5)"
"              ->  Seq Scan on seats s_1  (cost=0.00..189.00 rows=100 width=24) (actual time=0.136..0.911 rows=100 loops=1)"
"                    Filter: (hall_id = $0)"
"                    Rows Removed by Filter: 9900"
"Planning Time: 1.299 ms"
"Execution Time: 2.867 ms"
```

## Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс
```
С использованием CREATE INDEX tickets_sessions_price on tickets (session_id, price);

"Hash Join  (cost=66.20..122.20 rows=4512 width=24) (actual time=0.915..0.918 rows=1 loops=1)"
"  Hash Cond: (t.session_id = t_1.session_id)"
"  ->  GroupAggregate  (cost=0.43..44.39 rows=950 width=16) (actual time=0.537..0.537 rows=1 loops=1)"
"        Group Key: t.session_id"
"        ->  Index Only Scan using tickets_sessions_price on tickets t  (cost=0.43..29.90 rows=998 width=16) (actual time=0.140..0.407 rows=546 loops=1)"
"              Index Cond: (session_id = 2)"
"              Heap Fetches: 0"
"  ->  Hash  (cost=53.89..53.89 rows=950 width=16) (actual time=0.370..0.371 rows=1 loops=1)"
"        Buckets: 1024  Batches: 1  Memory Usage: 9kB"
"        ->  GroupAggregate  (cost=0.43..44.39 rows=950 width=16) (actual time=0.365..0.366 rows=1 loops=1)"
"              Group Key: t_1.session_id"
"              ->  Index Only Scan using tickets_sessions_price on tickets t_1  (cost=0.43..29.90 rows=998 width=16) (actual time=0.025..0.254 rows=546 loops=1)"
"                    Index Cond: (session_id = 2)"
"                    Heap Fetches: 0"
"Planning Time: 0.817 ms"
"Execution Time: 0.976 ms"
```
