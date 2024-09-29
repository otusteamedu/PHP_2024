-- 4 Поиск 3 самых прибыльных фильмов за неделю

SELECT movie.title, SUM(ticket.tariff_price) AS sumPerMovie
FROM ticket ticket  
JOIN schedule schedule ON schedule.id = ticket.schedule_id
JOIN movie movie ON movie.id = schedule.movie_id
WHERE schedule.time_begin BETWEEN CURRENT_DATE - interval '6 days' AND NOW()
GROUP BY movie.id
ORDER BY sumPerMovie DESC;

-- 10.000 строк в таблицах movie, schedule, ticket

"Sort  (cost=549.57..550.35 rows=310 width=62) (actual time=2.466..2.468 rows=1 loops=1)"
"  Sort Key: (sum(ticket.tariff_price)) DESC"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  GroupAggregate  (cost=526.25..536.75 rows=310 width=62) (actual time=2.461..2.463 rows=1 loops=1)"
"        Group Key: movie.id"
"        ->  Merge Join  (cost=526.25..531.32 rows=310 width=35) (actual time=2.326..2.400 rows=600 loops=1)"
"              Merge Cond: (movie.id = schedule.movie_id)"
"              ->  Index Scan using movie_pkey on movie  (cost=0.29..397.29 rows=10000 width=30) (actual time=0.005..0.007 rows=2 loops=1)"
"              ->  Sort  (cost=525.96..526.74 rows=310 width=9) (actual time=2.317..2.336 rows=600 loops=1)"
"                    Sort Key: schedule.movie_id"
"                    Sort Method: quicksort  Memory: 48kB"
"                    ->  Hash Join  (cost=312.88..513.14 rows=310 width=9) (actual time=1.281..2.276 rows=600 loops=1)"
"                          Hash Cond: (ticket.schedule_id = schedule.id)"
"                          ->  Seq Scan on ticket  (cost=0.00..174.00 rows=10000 width=9) (actual time=0.003..0.459 rows=10000 loops=1)"
"                          ->  Hash  (cost=309.00..309.00 rows=310 width=8) (actual time=1.272..1.273 rows=300 loops=1)"
"                                Buckets: 1024  Batches: 1  Memory Usage: 20kB"
"                                ->  Seq Scan on schedule  (cost=0.00..309.00 rows=310 width=8) (actual time=0.004..1.247 rows=300 loops=1)"
"                                      Filter: ((time_begin <= now()) AND (time_begin >= (CURRENT_DATE - '6 days'::interval)))"
"                                      Rows Removed by Filter: 9700"
"Planning Time: 0.566 ms"
"Execution Time: 3.753 ms"

-- 1.000.000 строк в таблицах movie, schedule, ticket

"Sort  (cost=16662.79..16663.52 rows=289 width=63) (actual time=100.703..101.972 rows=1 loops=1)"
"  Sort Key: (sum(ticket.tariff_price)) DESC"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  GroupAggregate  (cost=16642.59..16650.98 rows=289 width=63) (actual time=100.675..101.944 rows=1 loops=1)"
"        Group Key: movie.id"
"        ->  Merge Join  (cost=16642.59..16645.92 rows=289 width=36) (actual time=100.310..101.718 rows=600 loops=1)"
"              Merge Cond: (schedule.movie_id = movie.id)"
"              ->  Gather Merge  (cost=16607.78..16641.44 rows=289 width=9) (actual time=100.278..101.611 rows=600 loops=1)"
"                    Workers Planned: 2"
"                    Workers Launched: 2"
"                    ->  Sort  (cost=15607.76..15608.06 rows=120 width=9) (actual time=97.637..97.648 rows=200 loops=3)"
"                          Sort Key: schedule.movie_id"
"                          Sort Method: quicksort  Memory: 48kB"
"                          Worker 0:  Sort Method: quicksort  Memory: 25kB"
"                          Worker 1:  Sort Method: quicksort  Memory: 25kB"
"                          ->  Hash Join  (cost=2990.19..15603.61 rows=120 width=9) (actual time=64.507..97.586 rows=200 loops=3)"
"                                Hash Cond: (ticket.schedule_id = schedule.id)"
"                                ->  Parallel Seq Scan on ticket  (cost=0.00..11519.67 rows=416667 width=9) (actual time=0.082..75.223 rows=333333 loops=3)"
"                                ->  Hash  (cost=2979.34..2979.34 rows=868 width=8) (actual time=0.415..0.416 rows=900 loops=3)"
"                                      Buckets: 1024  Batches: 1  Memory Usage: 44kB"
"                                      ->  Bitmap Heap Scan on schedule  (cost=17.33..2979.34 rows=868 width=8) (actual time=0.062..0.287 rows=900 loops=3)"
"                                            Recheck Cond: ((time_begin >= (CURRENT_DATE - '6 days'::interval)) AND (time_begin <= now()))"
"                                            Heap Blocks: exact=30"
"                                            ->  Bitmap Index Scan on time_begin_idx  (cost=0.00..17.12 rows=868 width=0) (actual time=0.048..0.048 rows=900 loops=3)"
"                                                  Index Cond: ((time_begin >= (CURRENT_DATE - '6 days'::interval)) AND (time_begin <= now()))"
"              ->  Index Scan using movie_pkey on movie  (cost=0.42..38330.43 rows=1000000 width=31) (actual time=0.027..0.028 rows=1 loops=1)"
"Planning Time: 1.038 ms"
"Execution Time: 102.041 ms"

/*
    Оптимизация: 

    индексы не меняют ситуацию к лучшему, применяем партиционирование и трюк с запросом к партиции с текущими данными
*/

"Sort  (cost=1062.27..1063.83 rows=622 width=63) (actual time=5.742..5.745 rows=1 loops=1)"
"  Sort Key: (sum(ticket.tariff_price)) DESC"
"  Sort Method: quicksort  Memory: 25kB"
"  ->  HashAggregate  (cost=1025.63..1033.41 rows=622 width=63) (actual time=5.735..5.740 rows=1 loops=1)"
"        Group Key: movie.id"
"        Batches: 1  Memory Usage: 49kB"
"        ->  Hash Join  (cost=442.30..1022.52 rows=622 width=36) (actual time=2.681..5.642 rows=600 loops=1)"
"              Hash Cond: (ticket.schedule_id = schedule.id)"
"              ->  Seq Scan on ticket_current ticket  (cost=0.00..472.00 rows=27200 width=9) (actual time=0.004..1.337 rows=27200 loops=1)"
"              ->  Hash  (cost=438.42..438.42 rows=311 width=35) (actual time=2.672..2.673 rows=300 loops=1)"
"                    Buckets: 1024  Batches: 1  Memory Usage: 28kB"
"                    ->  Merge Join  (cost=433.30..438.42 rows=311 width=35) (actual time=2.598..2.641 rows=300 loops=1)"
"                          Merge Cond: (movie.id = schedule.movie_id)"
"                          ->  Index Scan using movie_pkey on movie  (cost=0.42..38330.43 rows=1000000 width=31) (actual time=0.005..0.007 rows=11 loops=1)"
"                          ->  Sort  (cost=432.88..433.65 rows=311 width=8) (actual time=2.589..2.599 rows=300 loops=1)"
"                                Sort Key: schedule.movie_id"
"                                Sort Method: quicksort  Memory: 34kB"
"                                ->  Seq Scan on schedule_current schedule  (cost=0.00..420.00 rows=311 width=8) (actual time=0.005..2.550 rows=300 loops=1)"
"                                      Filter: ((time_begin <= now()) AND (time_begin >= (CURRENT_DATE - '6 days'::interval)))"
"                                      Rows Removed by Filter: 13300"
"Planning Time: 0.351 ms"
"Execution Time: 5.789 ms"

-- эффект достигнут :-)