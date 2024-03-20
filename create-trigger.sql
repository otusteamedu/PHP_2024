CREATE OR REPLACE FUNCTION increase_session_counters()
    RETURNS trigger AS
$$
BEGIN
    if (tg_op = 'INSERT') then
        update session
        set ticket_count = ticket_count + 1,
            earned_money = earned_money + new.price
        where id = new.session_id;
        return new;
    end if;
    if (tg_op = 'UPDATE') then
        update session set earned_money = earned_money - old.price + new.price where id = new.session_id;
        return new;
    end if;
    if (tg_op = 'DELETE') then
        update session
        set ticket_count = ticket_count - 1, earned_money = earned_money - old.price
        where id = new.session_id;
        return old;
    end if;
END
$$ LANGUAGE 'plpgsql';

create or replace trigger increase_session_counters
    after insert or update or delete
    on ticket
    for each row
execute procedure increase_session_counters();