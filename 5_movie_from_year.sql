--query
EXPLAIN(SELECT * FROM movies
    WHERE EXTRACT(YEAR from release_date) = 1995);

-- with 10000 rows
--Seq Scan on movies  (cost=0.00..224.06 rows=50 width=28)
--  Filter: (EXTRACT(year FROM release_date) = '1995'::numeric)

-- with 100000 rows
--Seq Scan on movies  (cost=0.00..2449.52 rows=547 width=28)
--  Filter: (EXTRACT(year FROM release_date) = '1995'::numeric)

-- для ускорения работы использован функциональный индекс
CREATE INDEX idx_movies_year ON movies ((EXTRACT(YEAR FROM release_date)));

--Bitmap Heap Scan on movies  (cost=12.68..786.09 rows=550 width=29)
--Recheck Cond: (EXTRACT(year FROM release_date) = '1995'::numeric)
--  ->  Bitmap Index Scan on idx_movies_year  (cost=0.00..12.54 rows=550 width=0)
--        Index Cond: (EXTRACT(year FROM release_date) = '1995'::numeric)
