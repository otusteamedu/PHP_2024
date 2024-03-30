truncate public.ticket cascade;
truncate public.session cascade;
truncate public.movie_genre cascade;
truncate public.movie cascade;
truncate public.auditorium cascade;

drop function if exists insert_movies_and_auditoriums;

create or replace function insert_movies_and_auditoriums(begin_date text, total integer) returns void as $$
declare
    counter integer;
    country_ids smallint[] := array(select id from public.country);
    countries_count integer := array_length(country_ids, 1);
    duration_value integer := 50;
begin
    for counter in
        select current from generate_series(1, total, 1) current
        loop
            insert into public.auditorium (name) values ('Auditorium ' || counter);
            insert into public.movie (name, duration, country_id, start_date) values ('Movie ' || counter, duration_value, country_ids[floor(random() * countries_count + 1)], begin_date::date);
        end loop;
end;
$$ language plpgsql;

create or replace function insertSessions() returns void as $$
declare
    movie_ids smallint[] := array(select id from public.movie);
    auditorium_ids smallint[] := array(select id from public.auditorium);
    auditorium_id integer;
    mov_id integer;
    start_time time;
    loop_index integer := 0;
    prices numeric(5,2)[] := array[10.50, 12.00, 15.00];
    price_index integer;
    start_times time[] := '{00:00:00, 01:00:00, 02:00:00, 03:00:00, 04:00:00, 05:00:00, 06:00:00, 07:00:00, 08:00:00, 09:00:00, 10:00:00, 11:00:00, 12:00:00, 13:00:00, 14:00:00, 15:00:00, 16:00:00, 17:00:00, 18:00:00, 19:00:00, 20:00:00, 21:00:00, 22:00:00, 23:00:00}'::time[];

begin
    foreach mov_id in array movie_ids
        loop
            loop_index := loop_index + 1;
            auditorium_id := auditorium_ids[loop_index];
            
            foreach start_time in array start_times
            loop
                price_index := floor(random() * array_length(prices, 1)) + 1;
                insert into public.session (movie_id, auditorium_id, price, start_time) values (mov_id, auditorium_id, prices[price_index], start_time);
            end loop;
        end loop;
end;
$$ language plpgsql;

drop function if exists insert_tickets;

create or replace function insert_tickets(start_date text, last_date text, sales_parameter integer) returns void as $$
declare
    dt date;
    ses_id text;
    st_id text;
begin
    for dt in
        select date_trunc('day', dd):: date
        from generate_series( start_date::timestamp, last_date::timestamp, '1 day'::interval) dd
        loop
            for ses_id in
                select id from public.session
                loop
                    for st_id in
                        select id from public.seat
                        loop
                            continue when floor(random() * sales_parameter + 1)::int = 1;
                            insert into public.ticket (date, session_id, seat_id) values (dt::date, ses_id::integer, st_id::integer);
                        end loop;
                end loop;
        end loop;
end;
$$ language plpgsql;

do
$$
    begin
        perform insert_movies_and_auditoriums('2023-12-01', 50);
    end
$$;

do
$$
    begin
        perform insertSessions();
    end
$$;

do
$$
    begin
        perform insert_tickets('2023-12-01', '2024-04-14', 50);
    end
$$;
