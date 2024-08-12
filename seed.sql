-- noinspection SqlWithoutWhereForFile

delete
from ticket;
delete
from session;
delete
from attribute_value;
delete
from attribute;
delete
from movie;
delete
from attribute_type;
delete
from hall;

create or replace function random_timestamp() returns timestamp as
$$
declare
    result timestamp;
begin
    result := NOW() + (random() * (interval '30 days')) + '1 days';
    return result;
end;
$$ language plpgsql;

create or replace function random_number(start int, stop int) returns int as
$$
declare
    result int;
begin
    result := start + random() * (stop - start);
    return result;
end;
$$ language plpgsql;

create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;


insert into attribute_type (id, type_name)
values (1, 'timestamp'),
       (2, 'boolean'),
       (3, 'text'),
       (4, 'float');

do
$$
    begin
        for counter in 1..1000
            loop
                insert into movie (id, title) values (counter, counter || random_string(random_number(1, 30)));
            end loop;
        for counter in 1..100
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, counter || random_string(random_number(1, 10)), 1,
                        counter || random_string(random_number(1, 10)));
            end loop;
        for counter in 101..200
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, counter || random_string(random_number(1, 11)), 2,
                        counter || random_string(random_number(1, 11)));
            end loop;
        for counter in 201..300
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, counter || random_string(random_number(1, 12)), 3,
                        counter || random_string(random_number(1, 12)));
            end loop;
        for counter in 301..400
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, counter || random_string(random_number(1, 13)), 4,
                        counter || random_string(random_number(1, 13)));
            end loop;
    end;
$$;

do
$$
    declare
        type integer;
    begin
        for counter in 1..100000
            loop
                type = random_number(1, 4);
                case
                    when type = 1 then -- timestamp
                    insert into attribute_value(id, attribute_id, movie_id, timestamp_value)
                    values (counter, random_number(1, 100), random_number(1, 1000), random_timestamp());
                    when type = 2 then -- bool
                    insert into attribute_value(id, attribute_id, movie_id, bool_value)
                    values (counter, random_number(101, 200), random_number(1, 1000), random_number(1, 2) = 1);
                    when type = 3 then -- text
                    insert into attribute_value(id, attribute_id, movie_id, text_value)
                    values (counter, random_number(201, 300), random_number(1, 1000),
                            random_string(random_number(200, 500)));
                    when type = 4 then -- float
                    insert into attribute_value(id, attribute_id, movie_id, float_value)
                    values (counter, random_number(301, 400), random_number(1, 1000), random_number(100, 1000));
                    end case;
            end loop;
    end;
$$;

do
$$
    begin
        for counter in 1..10
            loop
                insert into hall (id, title, rows, cols)
                values (counter, random_string(random_number(10, 15)), random_number(10, 20), random_number(10, 20));
            end loop;
    end;
$$;

do
$$
    declare
        start_time timestamp;
    begin
        for counter in 1..100000
            loop
                start_time = random_timestamp();
                insert into session (id, movie_id, hall_id, start_time, end_time)
                values (counter, random_number(1, 1000), random_number(1, 10), start_time,
                        start_time + interval '2 hours');
            end loop;
    end;
$$;


do
$$
    begin
        for counter in 1..10000000
            loop
                insert into ticket (id, session_id, raw, col, price)
                values (counter, random_number(1, 100000), random_number(1, 40), random_number(1, 40),
                        random_number(200, 1000));
            end loop;
    end;
$$;
