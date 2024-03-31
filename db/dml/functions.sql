Create or replace function random_string(length integer) returns text as
$$
declare
  chars text[] := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
  result text := '';
  i integer := 0;
begin
  if length < 0 then
    raise exception 'Given length cannot be less than 0';
  end if;
  for i in 1..length loop
    result := result || chars[1+random()*(array_length(chars, 1)-1)];
  end loop;
  return result;
end;
$$ language plpgsql;

Create or replace function random_duration() returns interval as
$$
begin
  return (random() * 2 + 1) * interval '1 hour' + random() * 59 * interval '1 minute';
end;
$$ language plpgsql;

Create or replace function random_integer(low integer, high integer) returns integer as
$$
begin
  return (random() * (high - low)) + low;
end;
$$ language plpgsql;

CREATE TYPE attrigutes_types AS ENUM ('boolean', 'text', 'date', 'float');

Create or replace function random_attribute_type() returns attrigutes_types as
$$
begin
  return (array['boolean', 'text', 'date', 'float'])[floor(random() * 4 + 1)];
end;
$$ language plpgsql;

Create or replace function random_text_value_or_null() returns text as
$$
begin
    if random() > 0.5 then
        return random_string((1 + random()*100)::integer);
    end if;
    return NULL;
end;
$$ language plpgsql;

Create or replace function random_date_or_null() returns date as
$$
begin
    if random() > 0.5 then
        return now() + (random() * (now() + '90 days' - now())) + '30 days';
    end if;
    return NULL;
end;
$$ language plpgsql;

Create or replace function random_timestamp() returns timestamp as
$$
begin
    return ('2024-01-01 00:00:00'::timestamp +
  interval '1 day' *
  random() * 366 + interval '1 hour' * random() * 24);
end;
$$ language plpgsql;