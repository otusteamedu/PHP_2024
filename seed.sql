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

create or replace function random_timestamp() returns timestamp as
$$
declare
    result timestamp;
begin
    result := NOW() + (random() * (interval '90 days')) + '30 days';
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
        for counter in 1..100
            loop
                insert into movie (id, title) values (counter, random_string(random_number(1, 10)));
            end loop;
        for counter in 1..10
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, random_string(random_number(1, 10)), 1, random_string(random_number(1, 10)));
            end loop;
        for counter in 11..20
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, random_string(random_number(1, 10)), 2, random_string(random_number(1, 10)));
            end loop;
        for counter in 21..30
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, random_string(random_number(1, 10)), 3, random_string(random_number(1, 10)));
            end loop;
        for counter in 31..40
            loop
                insert into attribute (id, name, type_id, title)
                values (counter, random_string(random_number(1, 10)), 4, random_string(random_number(1, 10)));
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
                    values (counter, random_number(1, 10), random_number(1, 100), random_timestamp());
                    when type = 2 then -- bool
                    insert into attribute_value(id, attribute_id, movie_id, bool_value)
                    values (counter, random_number(1, 10), random_number(1, 100), random_number(1, 2) = 1);
                    when type = 3 then -- text
                    insert into attribute_value(id, attribute_id, movie_id, text_value)
                    values (counter, random_number(1, 10), random_number(1, 100),
                            random_string(random_number(200, 500)));
                    when type = 4 then -- float
                    insert into attribute_value(id, attribute_id, movie_id, float_value)
                    values (counter, random_number(1, 10), random_number(1, 100), random_number(100, 1000));
                    end case;
            end loop;
    end;
$$;
