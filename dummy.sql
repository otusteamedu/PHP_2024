create function random_date(startDate timestamp, finishDate timestamp) returns timestamp
language plpgsql
as
$$
begin
    if startDate > finishDate then
        raise exception 'Given incorrect time interval';
    end if;
    return startDate + (finishDate - startDate) * random();
end;
$$;

insert into halls (name, deleted_at)
select
    'Hall ' || generate_series(1, 5),
    null;

do $$
declare
    hall record;
    r int;
    c int;
begin
    for hall in select * from halls loop
        for r in 1..5 loop
            for c in 1..10 loop
                insert into seats (row, place, hall_id, deleted_at)
                values (r, c, hall.id, null);
            end loop ;
        end loop ;
    end loop ;
end $$;

insert into  movies (title, description, publish_year, duration, deleted_at)
select
    'Movie #' || generate_series(1, 1000000),
    'Description #' || generate_series(1, 1000000),
    extract(year from random_date('1950-01-01 00:00:00'::timestamp, now()::timestamp))::integer,
    (1 + random()*3)::integer,
    case when random() < 0.7 then null
         else random_date('2015-01-01 00:00:00'::timestamp, now()::timestamp)
    end;

do $$
    declare
        st timestamp;
        hall record;
        movieId int;
begin
    for st in(select generate_series('2024-05-15 00:00:00'::timestamp, '2024-12-31 22:00'::timestamp, '2.5 hours'::interval)) loop
        for hall in (select * from halls) loop
            movieId = (select id from movies order by random() limit 1);
            insert into sessions(start_at, finish_at, movie_id, deleted_at)
            values (
                    st,
                    st + interval '2 hours',
                    movieId,
                    case when random() < 0.7 then null
                        else random_date('2024-07-15 00:00:00'::timestamp, now()::timestamp)
                    end
                   );
        end loop;
    end loop;
end $$;

do $$
    declare
        session record;
        hallId int;
        seat record;
begin
        for session in (select * from sessions) loop
            hallId = (random() * 3)::integer + 1;
            for seat in (select * from seats where hall_id = hallId) loop
                insert into tickets (session_id, seat_id, price, deleted_at)
                values (
                        session.id,
                        seat.id,
                        random() * 10,
                        case when random() < 0.7 then null
                             else random_date('2015-01-01 00:00:00'::timestamp, now()::timestamp)
                        end
                );
            end loop;
        end loop;
end $$;

INSERT INTO roles (name, deleted_at) VALUES
 ('Кассир', NULL),
('Зритель', NULL);

INSERT INTO users (email, name, created_at, deleted_at, role_id) VALUES
('1@ya.ru', 'Кассир #1', '2024-07-04 11:42:32', NULL, 1),
('2@ya.ru', 'Зритель #1', '2024-07-04 11:42:59', NULL, 2),
('3@ya.ru', 'Зритель #2', '2024-07-04 11:43:25', NULL, 2);

INSERT INTO order_statuses (name, deleted_at) VALUES
('Ожидает оплаты', NULL),
('Оплачен', NULL),
('Отменен', NULL);

insert into orders (user_id, status_id, created_at, deleted_at)
select
    (random() * 2)::integer + 1,
    (2 * random())::integer + 1,
    random_date('2024-07-15 00:00:00'::timestamp, now()::timestamp),
    case when random() < 0.7 then null
        else random_date('2024-07-15 00:00:00'::timestamp, now()::timestamp)
    end
from generate_series(1, 50000);

do $$
    declare
        order_rec record;
        session int;
        ticket record;
        randomLimit int;
        ticketCount int;
begin
    for order_rec in (select * from orders) loop
        session = (select id from sessions order by random() limit 1);
        randomLimit = (random() * 10)::integer + 1;
        for ticket in (select * from tickets where session_id = session order by random() limit randomLimit) loop
            ticketCount = (select count(*) from order_ticket where ticket_id = ticket.id);
            if ticketCount = 0 then
                insert into order_ticket (order_id, ticket_id)
                values(
                       order_rec.id,
                       ticket.id
                      );
            end if;
        end loop;
    end loop;
end $$;