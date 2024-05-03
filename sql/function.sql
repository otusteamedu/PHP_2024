CREATE OR REPLACE FUNCTION random_int(low INT, high INT) RETURNS INT AS
$$
BEGIN
    RETURN floor(random() * (high - low + 1) + low);
END;
$$ language plpgsql STRICT;


CREATE OR REPLACE FUNCTION random_str(length integer) returns text
    language plpgsql
as
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
$$;


CREATE OR REPLACE FUNCTION random_timestamp()
    RETURNS TIMESTAMP AS
$$
DECLARE
    start_year INT       := 1970;
    end_year   INT       := 2024;
    start_ts   TIMESTAMP := to_timestamp(start_year || '-01-01', 'YYYY-MM-DD');
    end_ts     TIMESTAMP := to_timestamp(end_year || '-12-31 23:59:59', 'YYYY-MM-DD HH24:MI:SS');
BEGIN
    RETURN start_ts + (random() * (end_ts - start_ts));
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION random_film_name() RETURNS TEXT AS
$$
DECLARE
    filmsList text[] := array ['Начало', 'Интерстеллар', 'Тёмный рыцарь', 'Дэдпул', 'Железный человек', 'Мстители: Эра Альтрона'];
BEGIN
    RETURN (filmsList::text[])[ceil(random() * array_length(filmsList::text[], 1))];
END;
$$ language plpgsql STRICT;

