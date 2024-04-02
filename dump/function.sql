\c cinema;
drop function if exists tickets_generate;
create function tickets_generate(qty integer) returns void
    language plpgsql
as
$$
DECLARE
    sessions_qty int := (SELECT max(id)
                         FROM sessions);
    zones_qty    int := (SELECT max(id)
                         FROM zones);
    visitors_qty int := (SELECT max(id)
                         FROM visitors);
BEGIN
    FOR ticket IN 1..qty
        LOOP
INSERT INTO tickets (session_id, zone_id, visitor_id, row, place, selling_price, sale_at)
VALUES (
           trunc(random() * sessions_qty + 1)::numeric,
           trunc(random() * zones_qty + 1)::numeric,
           trunc(random() * visitors_qty + 1)::numeric,
           trunc(random() * 5 + 1), trunc(random() * zones_qty + 1)::numeric,
           trunc(random()*(400-250)+250)::numeric,
           now()
       );
END LOOP;
END
$$;

do
    $$
begin
    perform tickets_generate(10000);
end
$$;