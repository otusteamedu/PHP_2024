---4. Поиск 3 самых прибыльных фильмов за неделю

SELECT films.name, sum(tickets.price) as total_summ
    from tickets
    JOIN cinema_show_seat on cinema_show_seat.id = tickets.cinema_show_seat_id
    JOIN cinema_shows on cinema_shows.id = cinema_show_seat.cinema_show_id
    JOIN films on films.id = cinema_shows.film_id
    WHERE cinema_shows.date BETWEEN CURRENT_DATE - interval '6 days' AND CURRENT_DATE
    GROUP BY films.id
    ORDER by total_summ desc
    LIMIT 3;

---10_000 записей
/*
 Limit  (cost=407.95..407.95 rows=3 width=552) (actual time=10.050..10.064 rows=2 loops=1)
   ->  Sort  (cost=407.95..408.27 rows=130 width=552) (actual time=10.048..10.060 rows=2 loops=1)
         Sort Key: (sum(tickets.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  HashAggregate  (cost=404.64..406.27 rows=130 width=552) (actual time=9.999..10.012 rows=2 loops=1)
               Group Key: films.id
               Batches: 1  Memory Usage: 40kB
               ->  Hash Join  (cost=232.33..397.85 rows=1359 width=525) (actual time=4.681..8.553 rows=7000 loops=1)
                     Hash Cond: (cinema_shows.film_id = films.id)
                     ->  Hash Join  (cost=219.40..381.24 rows=1359 width=13) (actual time=4.648..7.139 rows=7000 loops=1)
                           Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                           ->  Seq Scan on tickets  (cost=0.00..122.00 rows=7000 width=13) (actual time=0.004..0.525 rows=7000 loops=1)
                           ->  Hash  (cost=199.99..199.99 rows=1553 width=12) (actual time=4.618..4.623 rows=8000 loops=1)
                                 Buckets: 8192 (originally 2048)  Batches: 1 (originally 1)  Memory Usage: 439kB
                                 ->  Hash Join  (cost=39.91..199.99 rows=1553 width=12) (actual time=0.037..2.937 rows=8000 loops=1)
                                       Hash Cond: (cinema_show_seat.cinema_show_id = cinema_shows.id)
                                       ->  Seq Scan on cinema_show_seat  (cost=0.00..139.00 rows=8000 width=12) (actual time=0.008..0.847 rows=8000 loops=1)
                                       ->  Hash  (cost=37.00..37.00 rows=233 width=12) (actual time=0.008..0.010 rows=2 loops=1)
                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                             ->  Seq Scan on cinema_shows  (cost=0.00..37.00 rows=233 width=12) (actual time=0.005..0.006 rows=2 loops=1)
                                                   Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
                     ->  Hash  (cost=11.30..11.30 rows=130 width=520) (actual time=0.023..0.024 rows=5 loops=1)
                           Buckets: 1024  Batches: 1  Memory Usage: 9kB
                           ->  Seq Scan on films  (cost=0.00..11.30 rows=130 width=520) (actual time=0.016..0.018 rows=5 loops=1)
 Planning Time: 1.081 ms
 Execution Time: 10.190 ms
(26 rows)
*/

--10_000_000 записей
/*
 Limit  (cost=417909.38..417909.39 rows=3 width=552) (actual time=9871.056..10114.739 rows=3 loops=1)
   ->  Sort  (cost=417909.38..417909.71 rows=130 width=552) (actual time=9852.813..10096.495 rows=3 loops=1)
         Sort Key: (sum(tickets.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=417873.79..417907.70 rows=130 width=552) (actual time=9852.725..10096.418 rows=5 loops=1)
               Group Key: films.id
               ->  Gather Merge  (cost=417873.79..417904.13 rows=260 width=552) (actual time=9852.652..10096.337 rows=15 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Sort  (cost=416873.77..416874.09 rows=130 width=552) (actual time=9813.258..9813.693 rows=5 loops=3)
                           Sort Key: films.id
                           Sort Method: quicksort  Memory: 25kB
                           Worker 0:  Sort Method: quicksort  Memory: 25kB
                           Worker 1:  Sort Method: quicksort  Memory: 25kB
                           ->  Partial HashAggregate  (cost=416867.58..416869.20 rows=130 width=552) (actual time=9813.212..9813.650 rows=5 loops=3)
                                 Group Key: films.id
                                 Batches: 1  Memory Usage: 40kB
                                 Worker 0:  Batches: 1  Memory Usage: 40kB
                                 Worker 1:  Batches: 1  Memory Usage: 40kB
                                 ->  Hash Join  (cost=224042.65..400200.78 rows=3333360 width=525) (actual time=5927.173..9123.742 rows=2666667 loops=3)
                                       Hash Cond: (cinema_shows.film_id = films.id)
                                       ->  Hash Join  (cost=224029.73..391152.53 rows=3333360 width=13) (actual time=5916.743..8473.183 rows=2666667 loops=3)
                                             Hash Cond: (cinema_show_seat.cinema_show_id = cinema_shows.id)
                                             ->  Parallel Hash Join  (cost=224026.62..381781.30 rows=3333360 width=13) (actual time=5916.654..7832.013 rows=2666667 loops=3)
                                                   Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..92157.60 rows=3333360 width=13) (actual time=0.138..635.670 rows=2666667 loops=3)
                                                   ->  Parallel Hash  (cost=137545.50..137545.50 rows=4975050 width=12) (actual time=4434.847..4434.848 rows=3980000 loops=3)
                                                         Buckets: 262144  Batches: 128  Memory Usage: 6528kB
                                                         ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..137545.50 rows=4975050 width=12) (actual time=21.916..2917.395 rows=3980000 l
oops=3)
                                             ->  Hash  (cost=2.35..2.35 rows=60 width=12) (actual time=0.068..0.069 rows=60 loops=3)
                                                   Buckets: 1024  Batches: 1  Memory Usage: 11kB
                                                   ->  Seq Scan on cinema_shows  (cost=0.00..2.35 rows=60 width=12) (actual time=0.035..0.051 rows=60 loops=3)
                                                         Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
                                       ->  Hash  (cost=11.30..11.30 rows=130 width=520) (actual time=10.394..10.395 rows=5 loops=3)
                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                             ->  Seq Scan on films  (cost=0.00..11.30 rows=130 width=520) (actual time=10.367..10.370 rows=5 loops=3)
 Planning Time: 3.051 ms
 JIT:
   Functions: 103
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 4.365 ms, Inlining 0.000 ms, Optimization 1.952 ms, Emission 47.835 ms, Total 54.152 ms
 Execution Time: 10116.281 ms
(42 rows)
*/

/* Для этого запроса оптимизация была произведена в select_1 (добавлен индекс на cinema_shows.date) */

/* результат для 10_000_000 записей после добавления индекса
 Limit  (cost=417908.77..417908.77 rows=3 width=552) (actual time=7966.463..8147.365 rows=3 loops=1)
   ->  Sort  (cost=417908.77..417909.09 rows=130 width=552) (actual time=7945.887..8126.788 rows=3 loops=1)
         Sort Key: (sum(tickets.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=417873.18..417907.09 rows=130 width=552) (actual time=7945.812..8126.724 rows=5 loops=1)
               Group Key: films.id
               ->  Gather Merge  (cost=417873.18..417903.51 rows=260 width=552) (actual time=7945.783..8126.686 rows=15 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Sort  (cost=416873.15..416873.48 rows=130 width=552) (actual time=7903.372..7903.466 rows=5 loops=3)
                           Sort Key: films.id
                           Sort Method: quicksort  Memory: 25kB
                           Worker 0:  Sort Method: quicksort  Memory: 25kB
                           Worker 1:  Sort Method: quicksort  Memory: 25kB
                           ->  Partial HashAggregate  (cost=416866.96..416868.59 rows=130 width=552) (actual time=7903.340..7903.436 rows=5 loops=3)
                                 Group Key: films.id
                                 Batches: 1  Memory Usage: 40kB
                                 Worker 0:  Batches: 1  Memory Usage: 40kB
                                 Worker 1:  Batches: 1  Memory Usage: 40kB
                                 ->  Hash Join  (cost=224042.65..400200.30 rows=3333333 width=525) (actual time=3645.103..7161.294 rows=2666667 loops=3)
                                       Hash Cond: (cinema_shows.film_id = films.id)
                                       ->  Hash Join  (cost=224029.73..391152.12 rows=3333333 width=13) (actual time=3620.015..6471.815 rows=2666667 loops=3)
                                             Hash Cond: (cinema_show_seat.cinema_show_id = cinema_shows.id)
                                             ->  Parallel Hash Join  (cost=224026.62..381780.96 rows=3333333 width=13) (actual time=3619.906..5775.007 rows=2666667 loops=3)
                                                   Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=13) (actual time=0.113..650.797 rows=2666667 loops=3)
                                                   ->  Parallel Hash  (cost=137545.50..137545.50 rows=4975050 width=12) (actual time=2075.568..2075.569 rows=3980000 loops=3)
                                                         Buckets: 262144  Batches: 128  Memory Usage: 6496kB
                                                         ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..137545.50 rows=4975050 width=12) (actual time=0.081..872.947 rows=3980000 loo
ps=3)
                                             ->  Hash  (cost=2.35..2.35 rows=60 width=12) (actual time=0.081..0.082 rows=60 loops=3)
                                                   Buckets: 1024  Batches: 1  Memory Usage: 11kB
                                                   ->  Seq Scan on cinema_shows  (cost=0.00..2.35 rows=60 width=12) (actual time=0.051..0.066 rows=60 loops=3)
                                                         Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
                                       ->  Hash  (cost=11.30..11.30 rows=130 width=520) (actual time=25.053..25.054 rows=5 loops=3)
                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                             ->  Seq Scan on films  (cost=0.00..11.30 rows=130 width=520) (actual time=25.029..25.033 rows=5 loops=3)
 Planning Time: 0.791 ms
 JIT:
   Functions: 103
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 16.186 ms, Inlining 0.000 ms, Optimization 2.200 ms, Emission 93.917 ms, Total 112.302 ms
 Execution Time: 8149.828 ms
(42 rows)
*/

/* вывод - добавление индекса сократило Execution Time c 10116.281 ms до 8149.828 ms */

/* Предлагаемая ещё одна оптимизация - добавить индекс на поле cinema_show_seat.cinema_show_id */

CREATE INDEX idx_cinema_show_seat_cinema_show_id ON cinema_show_seat(cinema_show_id);

/* результат для 10_000_000 записей после добавления индекса

 Limit  (cost=417905.64..417905.65 rows=3 width=552) (actual time=8552.084..8738.825 rows=3 loops=1)
   ->  Sort  (cost=417905.64..417905.97 rows=130 width=552) (actual time=8530.008..8716.747 rows=3 loops=1)
         Sort Key: (sum(tickets.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=417870.05..417903.96 rows=130 width=552) (actual time=8529.923..8716.672 rows=5 loops=1)
               Group Key: films.id
               ->  Gather Merge  (cost=417870.05..417900.39 rows=260 width=552) (actual time=8529.900..8716.641 rows=15 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Sort  (cost=416870.03..416870.35 rows=130 width=552) (actual time=8479.650..8479.753 rows=5 loops=3)
                           Sort Key: films.id
                           Sort Method: quicksort  Memory: 25kB
                           Worker 0:  Sort Method: quicksort  Memory: 25kB
                           Worker 1:  Sort Method: quicksort  Memory: 25kB
                           ->  Partial HashAggregate  (cost=416863.84..416865.46 rows=130 width=552) (actual time=8479.609..8479.715 rows=5 loops=3)
                                 Group Key: films.id
                                 Batches: 1  Memory Usage: 40kB
                                 Worker 0:  Batches: 1  Memory Usage: 40kB
                                 Worker 1:  Batches: 1  Memory Usage: 40kB
                                 ->  Hash Join  (cost=224040.52..400197.17 rows=3333333 width=525) (actual time=4262.844..7712.619 rows=2666667 loops=3)
                                       Hash Cond: (cinema_shows.film_id = films.id)
                                       ->  Hash Join  (cost=224027.60..391148.99 rows=3333333 width=13) (actual time=4220.408..6984.987 rows=2666667 loops=3)
                                             Hash Cond: (cinema_show_seat.cinema_show_id = cinema_shows.id)
                                             ->  Parallel Hash Join  (cost=224024.50..381777.83 rows=3333333 width=13) (actual time=4220.303..6273.144 rows=2666667 loops=3)
                                                   Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=13) (actual time=4.055..531.766 rows=2666667 loops=3)
                                                   ->  Parallel Hash  (cost=137545.00..137545.00 rows=4975000 width=12) (actual time=1938.732..1938.733 rows=3980000 loops=3)
                                                         Buckets: 262144  Batches: 128  Memory Usage: 6496kB
                                                         ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..137545.00 rows=4975000 width=12) (actual time=4.218..800.869 rows=3980000 loo
ps=3)
                                             ->  Hash  (cost=2.35..2.35 rows=60 width=12) (actual time=0.082..0.083 rows=60 loops=3)
                                                   Buckets: 1024  Batches: 1  Memory Usage: 11kB
                                                   ->  Seq Scan on cinema_shows  (cost=0.00..2.35 rows=60 width=12) (actual time=0.048..0.064 rows=60 loops=3)
                                                         Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
                                       ->  Hash  (cost=11.30..11.30 rows=130 width=520) (actual time=42.399..42.400 rows=5 loops=3)
                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                             ->  Seq Scan on films  (cost=0.00..11.30 rows=130 width=520) (actual time=42.372..42.376 rows=5 loops=3)
 Planning Time: 1.711 ms
 JIT:
   Functions: 103
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 5.916 ms, Inlining 0.000 ms, Optimization 3.023 ms, Emission 146.502 ms, Total 155.441 ms
 Execution Time: 8771.245 ms
(42 rows)
*/

/* вывод - добавление индекса не дало увеличение производительности запроса. удалим индекс командой */

DROP INDEX idx_cinema_show_seat_cinema_show_id;

/* Предлагаемая ещё одна оптимизация - добавить индекс на поле cinema_shows.film_id */

CREATE INDEX idx_cinema_shows_film_id ON cinema_shows(film_id);

/* результат для 10_000_000 записей после добавления индекса

 Limit  (cost=417905.64..417905.65 rows=3 width=552) (actual time=8084.377..8279.184 rows=3 loops=1)
   ->  Sort  (cost=417905.64..417905.97 rows=130 width=552) (actual time=8063.975..8258.781 rows=3 loops=1)
         Sort Key: (sum(tickets.price)) DESC
         Sort Method: quicksort  Memory: 25kB
         ->  Finalize GroupAggregate  (cost=417870.05..417903.96 rows=130 width=552) (actual time=8063.888..8258.706 rows=5 loops=1)
               Group Key: films.id
               ->  Gather Merge  (cost=417870.05..417900.39 rows=260 width=552) (actual time=8063.834..8258.643 rows=15 loops=1)
                     Workers Planned: 2
                     Workers Launched: 2
                     ->  Sort  (cost=416870.03..416870.35 rows=130 width=552) (actual time=7978.534..7978.649 rows=5 loops=3)
                           Sort Key: films.id
                           Sort Method: quicksort  Memory: 25kB
                           Worker 0:  Sort Method: quicksort  Memory: 25kB
                           Worker 1:  Sort Method: quicksort  Memory: 25kB
                           ->  Partial HashAggregate  (cost=416863.84..416865.46 rows=130 width=552) (actual time=7978.493..7978.610 rows=5 loops=3)
                                 Group Key: films.id
                                 Batches: 1  Memory Usage: 40kB
                                 Worker 0:  Batches: 1  Memory Usage: 40kB
                                 Worker 1:  Batches: 1  Memory Usage: 40kB
                                 ->  Hash Join  (cost=224040.52..400197.17 rows=3333333 width=525) (actual time=3656.497..7177.539 rows=2666667 loops=3)
                                       Hash Cond: (cinema_shows.film_id = films.id)
                                       ->  Hash Join  (cost=224027.60..391148.99 rows=3333333 width=13) (actual time=3636.736..6470.932 rows=2666667 loops=3)
                                             Hash Cond: (cinema_show_seat.cinema_show_id = cinema_shows.id)
                                             ->  Parallel Hash Join  (cost=224024.50..381777.83 rows=3333333 width=13) (actual time=3636.628..5751.705 rows=2666667 loops=3)
                                                   Hash Cond: (tickets.cinema_show_seat_id = cinema_show_seat.id)
                                                   ->  Parallel Seq Scan on tickets  (cost=0.00..92157.33 rows=3333333 width=13) (actual time=0.098..532.193 rows=2666667 loops=3)
                                                   ->  Parallel Hash  (cost=137545.00..137545.00 rows=4975000 width=12) (actual time=2317.329..2317.330 rows=3980000 loops=3)
                                                         Buckets: 262144  Batches: 128  Memory Usage: 6496kB
                                                         ->  Parallel Seq Scan on cinema_show_seat  (cost=0.00..137545.00 rows=4975000 width=12) (actual time=0.044..884.176 rows=3980000 loo
ps=3)
                                             ->  Hash  (cost=2.35..2.35 rows=60 width=12) (actual time=0.082..0.083 rows=60 loops=3)
                                                   Buckets: 1024  Batches: 1  Memory Usage: 11kB
                                                   ->  Seq Scan on cinema_shows  (cost=0.00..2.35 rows=60 width=12) (actual time=0.046..0.063 rows=60 loops=3)
                                                         Filter: ((date <= CURRENT_DATE) AND (date >= (CURRENT_DATE - '6 days'::interval)))
                                       ->  Hash  (cost=11.30..11.30 rows=130 width=520) (actual time=19.729..19.730 rows=5 loops=3)
                                             Buckets: 1024  Batches: 1  Memory Usage: 9kB
                                             ->  Seq Scan on films  (cost=0.00..11.30 rows=130 width=520) (actual time=19.701..19.704 rows=5 loops=3)
 Planning Time: 1.731 ms
 JIT:
   Functions: 103
   Options: Inlining false, Optimization false, Expressions true, Deforming true
   Timing: Generation 17.365 ms, Inlining 0.000 ms, Optimization 2.368 ms, Emission 77.504 ms, Total 97.237 ms
 Execution Time: 8325.081 ms
(42 rows)
*/

/* вывод - добавление индекса не дало увеличение производительности запроса. удалим индекс командой */

DROP INDEX idx_cinema_shows_film_id;