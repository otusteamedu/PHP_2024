## Описание

1. Схема БД [ddl.sql](./ddl.sql)
2. Набор вспомогательных функций для вставки тестовых данных [functions.sql](./functions.sql)
3. Вставка тестовых данных [insert_data.sql](./insert_data.sql)

## Запросы

### Выбор всех фильмов на сегодня

* Запрос

```SQL
    select name from films where date_end <= CURRENT_DATE;
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Seq Scan on films  \(cost=0.00..73094.00 rows=15933 width=29\) \(actual time=0.046..339.236 rows=16629 loops=1\) |
|   [Filter: \(date\_end &lt;= \('now'::cstring\)::date\)]() |
|   Rows Removed by Filter: 983371 |
| Planning time: 0.473 ms |
| Execution time: 339.539 ms |

* Добавил INDEX на основе условия WHERE

```SQL
    CREATE INDEX indx_films_date_end ON films (date_end);
```

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Bitmap Heap Scan on films  \(cost=172.31..15084.02 rows=15933 width=29\) \(actual time=3.843..72.308 rows=16629 loops=1\) |
|   Recheck Cond: \(date\_end &lt;= \('now'::cstring\)::date\) |
|   Heap Blocks: exact=7644 |
|   -&gt;  Bitmap Index Scan on indx\_films\_date\_end  \(cost=0.00..168.33 rows=15933 width=0\) \(actual time=2.649..2.649 rows=16629 loops=1\) |
|         Index Cond: \(date\_end &lt;= \('now'::cstring\)::date\) |
| Planning time: 0.270 ms |
| Execution time: 73.389 ms |

### Подсчёт проданных билетов за неделю

* Запрос

```SQL
    select count(t.id) from tickets t
    inner join sessions s on s.id = t.session_id
    where s.datetime_begin >= (now()::abstime::int - 24 * 60 * 60 * 7)
      and s.datetime_end <= now()::abstime::int;
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Aggregate  \(cost=65451.75..65451.76 rows=1 width=8\) \(actual time=630.891..630.891 rows=1 loops=1\) |
|   -&gt;  Hash Join  \(cost=35693.86..65173.97 rows=111111 width=4\) \(actual time=420.896..625.369 rows=240452 loops=1\) |
|         Hash Cond: \(t.session\_id = s.id\) |
|         -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=8\) \(actual time=0.018..49.279 rows=1000000 loops=1\) |
|         -&gt;  Hash  \(cost=33869.97..33869.97 rows=111111 width=4\) \(actual time=420.668..420.668 rows=241044 loops=1\) |
|               Buckets: 131072 \(originally 131072\)  Batches: 4 \(originally 2\)  Memory Usage: 3135kB |
|               -&gt;  Seq Scan on sessions s  \(cost=0.00..33869.97 rows=111111 width=4\) \(actual time=0.013..310.663 rows=241044 loops=1\) |
|                     Filter: \(\(datetime\_end &lt;= \(\(now\(\)\)::abstime\)::integer\) AND \(datetime\_begin &gt;= \(\(\(now\(\)\)::abstime\)::integer - 604800\)\)\) |
|                     Rows Removed by Filter: 758955 |
| Planning time: 0.452 ms |
| Execution time: 630.990 ms |


* Добавил составной INDEX в соответствии с условием выборки

```SQL
    CREATE INDEX indx_sessions_dates ON sessions (datetime_begin, datetime_end);
```

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Aggregate  \(cost=44040.15..44040.16 rows=1 width=8\) \(actual time=376.721..376.721 rows=1 loops=1\) |
|   -&gt;  Hash Join  \(cost=14282.27..43762.38 rows=111111 width=4\) \(actual time=162.615..371.465 rows=240474 loops=1\) |
|         Hash Cond: \(t.session\_id = s.id\) |
|         -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=8\) \(actual time=0.010..48.433 rows=1000000 loops=1\) |
|         -&gt;  Hash  \(cost=12458.38..12458.38 rows=111111 width=4\) \(actual time=162.456..162.456 rows=241068 loops=1\) |
|               Buckets: 131072 \(originally 131072\)  Batches: 4 \(originally 2\)  Memory Usage: 3135kB |
|               -&gt;  Index Scan using indx\_sessions\_dates on sessions s  \(cost=0.44..12458.38 rows=111111 width=4\) \(actual time=0.020..134.497 rows=241068 loops=1\) |
|                     Index Cond: \(\(datetime\_begin &gt;= \(\(\(now\(\)\)::abstime\)::integer - 604800\)\) AND \(datetime\_end &lt;= \(\(now\(\)\)::abstime\)::integer\)\) |
| Planning time: 0.221 ms |
| Execution time: 376.891 ms |


### Формирование афиши (фильмы, которые показывают сегодня)

* Запрос

```SQL
   select name, s.datetime_begin from films f
   inner join sessions s on f.id = s.film_id
   where s.datetime_end <= now()::date + interval '24h';
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Hash Join  \(cost=60531.69..90996.49 rows=50800 width=37\) \(actual time=388.937..682.257 rows=50312 loops=1\) |
|   Hash Cond: \(s.film\_id = f.id\) |
|   -&gt;  Seq Scan on sessions s  \(cost=0.00..28333.98 rows=50800 width=12\) \(actual time=0.043..170.534 rows=50312 loops=1\) |
|         [Filter: \(datetime\_end &lt;= \(\(now\(\)\)::date + '24:00:00'::interval\)\)]() |
|         Rows Removed by Filter: 949687 |
|   -&gt;  Hash  \(cost=57222.75..57222.75 rows=162875 width=33\) \(actual time=387.738..387.738 rows=1000000 loops=1\) |
|         Buckets: 65536 \(originally 65536\)  Batches: 32 \(originally 4\)  Memory Usage: 3585kB |
|         -&gt;  Seq Scan on films f  \(cost=0.00..57222.75 rows=162875 width=33\) \(actual time=0.024..253.014 rows=1000000 loops=1\) |
| Planning time: 1.036 ms |
| Execution time: 683.050 ms |

* Добавил INDEX на основе условия WHERE

```SQL
    CREATE INDEX indx_sessions_datetime_end ON sessions (datetime_end);
```

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Hash Join  \(cost=61079.82..72560.64 rows=50800 width=37\) \(actual time=234.119..369.732 rows=50312 loops=1\) |
|   Hash Cond: \(s.film\_id = f.id\) |
|   -&gt;  Bitmap Heap Scan on sessions s  \(cost=548.13..9898.13 rows=50800 width=12\) \(actual time=12.248..20.948 rows=50312 loops=1\) |
|         Recheck Cond: \(datetime\_end &lt;= \(\(now\(\)\)::date + '24:00:00'::interval\)\) |
|         Heap Blocks: exact=8317 |
|         -&gt;  Bitmap Index Scan on indx\_sessions\_datetime\_end  \(cost=0.00..535.43 rows=50800 width=0\) \(actual time=10.756..10.756 rows=50312 loops=1\) |
|               Index Cond: \(datetime\_end &lt;= \(\(now\(\)\)::date + '24:00:00'::interval\)\) |
|   -&gt;  Hash  \(cost=57222.75..57222.75 rows=162875 width=33\) \(actual time=221.228..221.228 rows=1000000 loops=1\) |
|         Buckets: 65536 \(originally 65536\)  Batches: 32 \(originally 4\)  Memory Usage: 3585kB |
|         -&gt;  Seq Scan on films f  \(cost=0.00..57222.75 rows=162875 width=33\) \(actual time=0.018..90.608 rows=1000000 loops=1\) |
| Planning time: 1.646 ms |
| Execution time: 370.607 ms |

### Поиск 3 самых прибыльных фильмов за неделю

* Запрос

```SQL
   select s.film_id, sum(t.price) sum_price from tickets t
   inner join sessions s on s.id = t.session_id
   where s.datetime_begin >= (CURRENT_TIMESTAMP - '7 days'::interval) and s.datetime_end <= now()::date
   group by s.film_id
   order by sum_price desc
   limit 3;
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Limit  \(cost=54917.24..54917.25 rows=3 width=12\) \(actual time=456.562..456.562 rows=3 loops=1\) |
|   -&gt;  Sort  \(cost=54917.24..54989.18 rows=28775 width=12\) \(actual time=456.561..456.561 rows=3 loops=1\) |
|         Sort Key: \(sum\(t.price\)\) DESC |
|         Sort Method: top-N heapsort  Memory: 25kB |
|         -&gt;  HashAggregate  \(cost=54257.58..54545.33 rows=28775 width=12\) \(actual time=454.822..455.833 rows=18570 loops=1\) |
|               Group Key: s.film\_id |
|               -&gt;  Hash Join  \(cost=33699.25..54111.47 rows=29222 width=8\) \(actual time=304.509..446.550 rows=29607 loops=1\) |
|                     Hash Cond: \(t.session\_id = s.id\) |
|                     -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=8\) \(actual time=0.020..60.323 rows=1000000 loops=1\) |
|                     -&gt;  Hash  \(cost=33333.98..33333.98 rows=29222 width=8\) \(actual time=304.369..304.369 rows=29766 loops=1\) |
|                           Buckets: 32768  Batches: 1  Memory Usage: 1419kB |
|                           -&gt;  Seq Scan on sessions s  \(cost=0.00..33333.98 rows=29222 width=8\) \(actual time=0.036..295.684 rows=29766 loops=1\) |
|                                 [Filter: \(\(datetime\_begin &gt;= \(now\(\) - '7 days'::interval\)\) AND \(datetime\_end &lt;= \(now\(\)\)::date\)\)]() |
|                                 Rows Removed by Filter: 970233 |
| Planning time: 1.683 ms |
| Execution time: 457.067 ms |

* После добавления indx_sessions_dates

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Limit  \(cost=44393.76..44393.77 rows=3 width=12\) \(actual time=182.409..182.410 rows=3 loops=1\) |
|   -&gt;  Sort  \(cost=44393.76..44465.68 rows=28766 width=12\) \(actual time=182.409..182.409 rows=3 loops=1\) |
|         Sort Key: \(sum\(t.price\)\) DESC |
|         Sort Method: top-N heapsort  Memory: 25kB |
|         -&gt;  HashAggregate  \(cost=43734.31..44021.97 rows=28766 width=12\) \(actual time=180.713..181.768 rows=18567 loops=1\) |
|               Group Key: s.film\_id |
|               -&gt;  Hash Join  \(cost=23176.13..43588.25 rows=29212 width=8\) \(actual time=64.161..172.959 rows=29598 loops=1\) |
|                     Hash Cond: \(t.session\_id = s.id\) |
|                     -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=8\) \(actual time=0.009..29.278 rows=1000000 loops=1\) |
|                     -&gt;  Hash  \(cost=22810.98..22810.98 rows=29212 width=8\) \(actual time=64.036..64.036 rows=29761 loops=1\) |
|                           Buckets: 32768  Batches: 1  Memory Usage: 1419kB |
|                           -&gt;  Bitmap Heap Scan on sessions s  \(cost=13746.68..22810.98 rows=29212 width=8\) \(actual time=43.587..50.938 rows=29761 loops=1\) |
|                                 Recheck Cond: \(\(datetime\_begin &gt;= \(now\(\) - '7 days'::interval\)\) AND \(datetime\_end &lt;= \(now\(\)\)::date\)\) |
|                                 Heap Blocks: exact=8102 |
|                                 -&gt;  Bitmap Index Scan on indx\_sessions\_group  \(cost=0.00..13739.38 rows=29212 width=0\) \(actual time=42.898..42.898 rows=29761 loops=1\) |
|                                       Index Cond: \(\(datetime\_begin &gt;= \(now\(\) - '7 days'::interval\)\) AND \(datetime\_end &lt;= \(now\(\)\)::date\)\) |
| Planning time: 0.260 ms |
| Execution time: 182.646 ms |

### Сформировать схему зала и показать на ней свободные и занятые места на конкретный сеанс

* Запрос

```SQL
   WITH s as (
     SELECT * FROM
        sessions
     WHERE sessions.id = 170
   )
   SELECT hrs.hall_row_id as row, hrs.number, CASE WHEN t.id is NOT NULL THEN 1 ELSE 0 END AS busy
   FROM s
   RIGHT JOIN hall_rows hr ON hr.hall_id = s.hall_id
   RIGHT JOIN hall_row_seats hrs ON hrs.hall_row_id = hr.id
   LEFT JOIN tickets t ON t.seat_id = hrs.id AND t.session_id = s.id
   ORDER BY row, number;
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Sort  \(cost=23880.98..23881.11 rows=50 width=12\) \(actual time=127.569..127.570 rows=50 loops=1\) |
|   Sort Key: hrs.hall\_row\_id, hrs.number |
|   Sort Method: quicksort  Memory: 27kB |
|   CTE s |
|     -&gt;  Index Scan using sessions\_pk on sessions  \(cost=0.42..2.64 rows=1 width=32\) \(actual time=0.019..0.020 rows=1 loops=1\) |
|           Index Cond: \(id = 170\) |
|   -&gt;  Hash Right Join  \(cost=6.91..23876.93 rows=50 width=12\) \(actual time=60.249..127.527 rows=50 loops=1\) |
|         [Hash Cond: \(\(t.seat\_id = hrs.id\) AND \(t.session\_id = s.id\)\)]() |
|         -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=12\) \(actual time=0.014..47.000 rows=1000000 loops=1\) |
|         -&gt;  Hash  \(cost=6.16..6.16 rows=50 width=16\) \(actual time=0.267..0.267 rows=50 loops=1\) |
|               Buckets: 1024  Batches: 1  Memory Usage: 11kB |
|               -&gt;  Hash Left Join  \(cost=3.28..6.16 rows=50 width=16\) \(actual time=0.111..0.246 rows=50 loops=1\) |
|                     Hash Cond: \(hr.hall\_id = s.hall\_id\) |
|                     -&gt;  Hash Left Join  \(cost=3.25..5.44 rows=50 width=16\) \(actual time=0.081..0.186 rows=50 loops=1\) |
|                           Hash Cond: \(hrs.hall\_row\_id = hr.id\) |
|                           -&gt;  Seq Scan on hall\_row\_seats hrs  \(cost=0.00..1.50 rows=50 width=12\) \(actual time=0.013..0.089 rows=50 loops=1\) |
|                           -&gt;  Hash  \(cost=2.00..2.00 rows=100 width=8\) \(actual time=0.059..0.059 rows=100 loops=1\) |
|                                 Buckets: 1024  Batches: 1  Memory Usage: 12kB |
|                                 -&gt;  Seq Scan on hall\_rows hr  \(cost=0.00..2.00 rows=100 width=8\) \(actual time=0.008..0.028 rows=100 loops=1\) |
|                     -&gt;  Hash  \(cost=0.02..0.02 rows=1 width=8\) \(actual time=0.025..0.025 rows=1 loops=1\) |
|                           Buckets: 1024  Batches: 1  Memory Usage: 9kB |
|                           -&gt;  CTE Scan on s  \(cost=0.00..0.02 rows=1 width=8\) \(actual time=0.021..0.022 rows=1 loops=1\) |
| Planning time: 0.703 ms |
| Execution time: 127.658 ms |

* Добавил INDEX на основе высокой стоимости операции, выделенной синим

```SQL
    CREATE INDEX indx_tickets_session_seat ON tickets (session_id, seat_id);
```

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Sort  \(cost=142.96..143.09 rows=50 width=12\) \(actual time=0.477..0.480 rows=50 loops=1\) |
|   Sort Key: hrs.hall\_row\_id, hrs.number |
|   Sort Method: quicksort  Memory: 27kB |
|   CTE s |
|     -&gt;  Index Scan using sessions\_pk on sessions  \(cost=0.42..2.64 rows=1 width=32\) \(actual time=0.060..0.060 rows=1 loops=1\) |
|           Index Cond: \(id = 170\) |
|   -&gt;  Nested Loop Left Join  \(cost=3.71..138.91 rows=50 width=12\) \(actual time=0.220..0.406 rows=50 loops=1\) |
|         -&gt;  Hash Left Join  \(cost=3.28..6.16 rows=50 width=16\) \(actual time=0.141..0.175 rows=50 loops=1\) |
|               Hash Cond: \(hr.hall\_id = s.hall\_id\) |
|               -&gt;  Hash Left Join  \(cost=3.25..5.44 rows=50 width=16\) \(actual time=0.063..0.080 rows=50 loops=1\) |
|                     Hash Cond: \(hrs.hall\_row\_id = hr.id\) |
|                     -&gt;  Seq Scan on hall\_row\_seats hrs  \(cost=0.00..1.50 rows=50 width=12\) \(actual time=0.008..0.011 rows=50 loops=1\) |
|                     -&gt;  Hash  \(cost=2.00..2.00 rows=100 width=8\) \(actual time=0.030..0.030 rows=100 loops=1\) |
|                           Buckets: 1024  Batches: 1  Memory Usage: 12kB |
|                           -&gt;  Seq Scan on hall\_rows hr  \(cost=0.00..2.00 rows=100 width=8\) \(actual time=0.004..0.014 rows=100 loops=1\) |
|               -&gt;  Hash  \(cost=0.02..0.02 rows=1 width=8\) \(actual time=0.069..0.069 rows=1 loops=1\) |
|                     Buckets: 1024  Batches: 1  Memory Usage: 9kB |
|                     -&gt;  CTE Scan on s  \(cost=0.00..0.02 rows=1 width=8\) \(actual time=0.061..0.061 rows=1 loops=1\) |
|         -&gt;  Index Scan using indx\_tickets\_session\_seat on tickets t  \(cost=0.42..2.64 rows=1 width=12\) \(actual time=0.003..0.003 rows=0 loops=50\) |
|               Index Cond: \(\(session\_id = s.id\) AND \(seat\_id = hrs.id\)\) |
| Planning time: 1.139 ms |
| Execution time: 0.610 ms |

### Вывести диапазон миниальной и максимальной цены за билет на конкретный сеанс

* Запрос

```SQL
   WITH s as (
     SELECT * FROM
        sessions
     WHERE sessions.id = 170
   )
   SELECT max(t.price), min(t.price) FROM s
   INNER JOIN tickets t ON t.session_id = s.id;
```

* EXPLAIN до оптимизации

| QUERY PLAN |
| :--- |
| Aggregate  \(cost=20122.71..20122.72 rows=1 width=8\) \(actual time=122.147..122.148 rows=1 loops=1\) |
|   CTE s |
|     -&gt;  Index Scan using sessions\_pk on sessions  \(cost=0.42..2.64 rows=1 width=32\) \(actual time=0.015..0.016 rows=1 loops=1\) |
|           Index Cond: \(id = 170\) |
|   -&gt;  Hash Join  \(cost=0.03..20120.05 rows=2 width=4\) \(actual time=49.035..122.141 rows=4 loops=1\) |
|         [Hash Cond: \(t.session\_id = s.id\)]() |
|         -&gt;  Seq Scan on tickets t  \(cost=0.00..16370.00 rows=1000000 width=8\) \(actual time=0.021..67.313 rows=1000000 loops=1\) |
|         -&gt;  Hash  \(cost=0.02..0.02 rows=1 width=4\) \(actual time=0.046..0.046 rows=1 loops=1\) |
|               Buckets: 1024  Batches: 1  Memory Usage: 9kB |
|               -&gt;  CTE Scan on s  \(cost=0.00..0.02 rows=1 width=4\) \(actual time=0.017..0.018 rows=1 loops=1\) |
| Planning time: 0.389 ms |
| Execution time: 122.228 ms |

* Добавил INDEX на основе высокой стоимости операции, выделенной синим

```SQL
    CREATE INDEX indx_tickets_session ON tickets (session_id);
```

* EXPLAIN после оптимизации

| QUERY PLAN |
| :--- |
| Aggregate  \(cost=6.45..6.46 rows=1 width=8\) \(actual time=0.365..0.365 rows=1 loops=1\) |
|   CTE s |
|     -&gt;  Index Scan using sessions\_pk on sessions  \(cost=0.42..2.64 rows=1 width=32\) \(actual time=0.057..0.057 rows=1 loops=1\) |
|           Index Cond: \(id = 170\) |
|   -&gt;  Nested Loop  \(cost=0.42..3.80 rows=2 width=4\) \(actual time=0.353..0.360 rows=4 loops=1\) |
|         -&gt;  CTE Scan on s  \(cost=0.00..0.02 rows=1 width=4\) \(actual time=0.059..0.059 rows=1 loops=1\) |
|         -&gt;  Index Scan using indx\_tickets\_session on tickets t  \(cost=0.42..3.76 rows=2 width=8\) \(actual time=0.068..0.073 rows=4 loops=1\) |
|               Index Cond: \(session\_id = s.id\) |
| Planning time: 0.603 ms |
| Execution time: 0.420 ms |

### Отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)

* Запрос

```SQL
   SELECT nspname || '.' || relname as name,
          pg_size_pretty(pg_total_relation_size(c.oid)) as totalsize,
          pg_size_pretty(pg_relation_size(c.oid)) as relsize
   FROM pg_class c
   LEFT JOIN pg_namespace n ON (n.oid = c.relnamespace)
   WHERE nspname NOT IN ('pg_catalog', 'information_schema')
   ORDER BY pg_total_relation_size(c.oid) DESC
   LIMIT 15;
```

* Результат

| name | totalsize | relsize |
| :--- | :--- | :--- |
| public.users | 979 MB | 432 MB |
| public.films | 566 MB | 434 MB |
| public.users\_name\_email\_unique | 439 MB | 439 MB |
| public.sessions | 138 MB | 65 MB |
| public.tickets | 114 MB | 50 MB |
| public.films\_pk | 110 MB | 110 MB |
| public.users\_pk | 107 MB | 107 MB |
| public.indx\_sessions\_dates | 30 MB | 30 MB |
| public.indx\_films\_date\_end | 21 MB | 21 MB |
| public.indx\_tickets\_session\_seat | 21 MB | 21 MB |
| public.indx\_tickets\_session | 21 MB | 21 MB |
| public.indx\_sessions\_datetime\_end | 21 MB | 21 MB |
| public.tickets\_pk | 21 MB | 21 MB |
| public.sessions\_pk | 21 MB | 21 MB |
| pg\_toast.pg\_toast\_2618 | 424 kB | 376 kB |

### Отсортированные списки (по 5 значений) самых часто и редко используемых индексов

* Запрос

```SQL
   SELECT
       pgstat.relname AS table_name,
       indexrelname AS index_name,
       pgstat.idx_scan AS index_scan_count,
       pg_size_pretty(pg_relation_size(indexrelid)) AS index_size,
       tabstat.idx_scan AS table_reads_index_count,
       tabstat.seq_scan AS table_reads_seq_count,
       tabstat.seq_scan + tabstat.idx_scan AS table_reads_count,
       n_tup_upd + n_tup_ins + n_tup_del AS table_writes_count,
       pg_size_pretty(pg_relation_size(pgstat.relid)) AS table_size
   FROM
       pg_stat_user_indexes AS pgstat
           JOIN
       pg_indexes
       ON
           indexrelname = indexname
               AND
           pgstat.schemaname = pg_indexes.schemaname
           JOIN
       pg_stat_user_tables AS tabstat
       ON
           pgstat.relid = tabstat.relid
   WHERE
       indexdef !~* 'unique'
   ORDER BY
       pgstat.idx_scan DESC,
       pg_relation_size(indexrelid) DESC;
```

* Результат

| table\_name | index\_name | index\_scan\_count | index\_size | table\_reads\_index\_count | table\_reads\_seq\_count | table\_reads\_count | table\_writes\_count | table\_size |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| sessions | indx\_sessions\_dates | 0 | 30 MB | 1001096 | 54 | 1001150 | 1001017 | 65 MB |
| films | indx\_films\_date\_end | 0 | 21 MB | 1001086 | 62 | 1001148 | 6144334 | 434 MB |
| sessions | indx\_sessions\_datetime\_end | 0 | 21 MB | 1001096 | 54 | 1001150 | 1001017 | 65 MB |
| tickets | indx\_tickets\_session\_seat | 0 | 21 MB | 0 | 93 | 93 | 1001026 | 50 MB |
| tickets | indx\_tickets\_session | 0 | 21 MB | 0 | 93 | 93 | 1001026 | 50 MB |
