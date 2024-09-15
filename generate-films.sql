insert into films(id, name, release_start, release_end, duration)
select
    (select id + uid from films order by id desc limit 1),
    md5(random()::text),
    '2000-01-01'::date + trunc(random() * 366 * 10)::int,
    '2000-01-01'::date + trunc(random() * 366 * 10)::int,
    floor(random()*(25-10+1))+10
from generate_series(1,100000) as uid