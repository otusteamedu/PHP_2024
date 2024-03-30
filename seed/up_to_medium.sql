truncate public.ticket;

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
        perform insert_tickets('2024-03-18', '2024-03-24', 30);
    end
$$;