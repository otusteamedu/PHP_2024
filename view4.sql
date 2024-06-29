--Поиск 3 самых прибыльных фильмов за неделю
select
ts.film_id, sum(tp.price) as profit
from tbl_ticket tt
inner join tbl_price tp ON tp.id = tt.price_id
inner join tbl_show ts on ts.id = tt.show_id
WHERE tt.time_paid BETWEEN CURRENT_DATE - (EXTRACT(DOW FROM CURRENT_DATE)::INTEGER - 1)
     AND CURRENT_DATE + (7 - EXTRACT(DOW FROM CURRENT_DATE)::INTEGER)
group by ts.film_id
order by profit desc
limit 3

/*
более 10000  записей
Limit  (cost=650.00..650.01 rows=3 width=12) (actual time=4.650..4.653 rows=3 loops=1)
  ->  Sort  (cost=650.00..650.37 rows=147 width=12) (actual time=4.648..4.650 rows=3 loops=1)
        Sort Key: (sum(tp.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  GroupAggregate  (cost=645.53..648.10 rows=147 width=12) (actual time=4.614..4.641 rows=34 loops=1)
              Group Key: ts.film_id
              ->  Sort  (cost=645.53..645.90 rows=147 width=12) (actual time=4.608..4.615 rows=148 loops=1)
                    Sort Key: ts.film_id
                    Sort Method: quicksort  Memory: 31kB
                    ->  Hash Join  (cost=480.97..640.24 rows=147 width=12) (actual time=4.504..4.586 rows=148 loops=1)
                          Hash Cond: (tt.show_id = ts.id)
                          ->  Hash Join  (cost=454.44..613.32 rows=147 width=12) (actual time=4.200..4.259 rows=148 loops=1)
                                Hash Cond: (tp.id = tt.price_id)
                                ->  Seq Scan on tbl_price tp  (cost=0.00..128.12 rows=7812 width=12) (actual time=0.004..0.389 rows=7812 loops=1)
                                ->  Hash  (cost=452.60..452.60 rows=147 width=8) (actual time=3.342..3.342 rows=148 loops=1)
                                      Buckets: 1024  Batches: 1  Memory Usage: 14kB
                                      ->  Seq Scan on tbl_ticket tt  (cost=0.00..452.60 rows=147 width=8) (actual time=3.155..3.319 rows=148 loops=1)
                                            Filter: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
                                            Rows Removed by Filter: 7664
                          ->  Hash  (cost=15.68..15.68 rows=868 width=8) (actual time=0.298..0.299 rows=868 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 42kB
                                ->  Seq Scan on tbl_show ts  (cost=0.00..15.68 rows=868 width=8) (actual time=0.036..0.167 rows=868 loops=1)
Planning Time: 0.585 ms
Execution Time: 4.700 ms

добавил индекс tbl_ticket_time_paid_idx

Limit  (cost=204.00..204.01 rows=3 width=12) (actual time=1.582..1.584 rows=3 loops=1)
  ->  Sort  (cost=204.00..204.37 rows=147 width=12) (actual time=1.581..1.583 rows=3 loops=1)
        Sort Key: (sum(tp.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=200.63..202.10 rows=147 width=12) (actual time=1.568..1.575 rows=34 loops=1)
              Group Key: ts.film_id
              Batches: 1  Memory Usage: 40kB
              ->  Hash Join  (cost=40.63..199.90 rows=147 width=12) (actual time=1.422..1.536 rows=148 loops=1)
                    Hash Cond: (tt.show_id = ts.id)
                    ->  Hash Join  (cost=14.10..172.98 rows=147 width=12) (actual time=1.207..1.293 rows=148 loops=1)
                          Hash Cond: (tp.id = tt.price_id)
                          ->  Seq Scan on tbl_price tp  (cost=0.00..128.12 rows=7812 width=12) (actual time=0.004..0.505 rows=7812 loops=1)
                          ->  Hash  (cost=12.26..12.26 rows=147 width=8) (actual time=0.080..0.080 rows=148 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 14kB
                                ->  Index Scan using tbl_ticket_time_paid_idx on tbl_ticket tt  (cost=0.32..12.26 rows=147 width=8) (actual time=0.032..0.060 rows=148 loops=1)
                                      Index Cond: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
                    ->  Hash  (cost=15.68..15.68 rows=868 width=8) (actual time=0.212..0.213 rows=868 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 42kB
                          ->  Seq Scan on tbl_show ts  (cost=0.00..15.68 rows=868 width=8) (actual time=0.008..0.111 rows=868 loops=1)
Planning Time: 0.461 ms
Execution Time: 1.636 ms

добавил индекс tbl_show_film_id_idx
Разница не значительна но планировщик тработал точнее
Limit  (cost=204.00..204.01 rows=3 width=12) (actual time=1.392..1.394 rows=3 loops=1)
  ->  Sort  (cost=204.00..204.37 rows=147 width=12) (actual time=1.391..1.393 rows=3 loops=1)
        Sort Key: (sum(tp.price)) DESC
        Sort Method: top-N heapsort  Memory: 25kB
        ->  HashAggregate  (cost=200.63..202.10 rows=147 width=12) (actual time=1.376..1.384 rows=34 loops=1)
              Group Key: ts.film_id
              Batches: 1  Memory Usage: 40kB
              ->  Hash Join  (cost=40.63..199.90 rows=147 width=12) (actual time=1.256..1.347 rows=148 loops=1)
                    Hash Cond: (tt.show_id = ts.id)
                    ->  Hash Join  (cost=14.10..172.98 rows=147 width=12) (actual time=1.022..1.090 rows=148 loops=1)
                          Hash Cond: (tp.id = tt.price_id)
                          ->  Seq Scan on tbl_price tp  (cost=0.00..128.12 rows=7812 width=12) (actual time=0.005..0.444 rows=7812 loops=1)
                          ->  Hash  (cost=12.26..12.26 rows=147 width=8) (actual time=0.058..0.059 rows=148 loops=1)
                                Buckets: 1024  Batches: 1  Memory Usage: 14kB
                                ->  Index Scan using tbl_ticket_time_paid_idx on tbl_ticket tt  (cost=0.32..12.26 rows=147 width=8) (actual time=0.011..0.039 rows=148 loops=1)
                                      Index Cond: ((time_paid >= (CURRENT_DATE - ((date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer - 1))) AND (time_paid <= (CURRENT_DATE + (7 - (date_part('dow'::text, (CURRENT_DATE)::timestamp without time zone))::integer))))
                    ->  Hash  (cost=15.68..15.68 rows=868 width=8) (actual time=0.228..0.229 rows=868 loops=1)
                          Buckets: 1024  Batches: 1  Memory Usage: 42kB
                          ->  Seq Scan on tbl_show ts  (cost=0.00..15.68 rows=868 width=8) (actual time=0.005..0.116 rows=868 loops=1)
Planning Time: 1.270 ms
Execution Time: 1.432 ms
*/