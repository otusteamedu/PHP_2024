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

-- 6 halls
insert into halls(name, basePrice)
  select
  	CONCAT ('Зал_', random_string(3)),
   	(250 + random()*500)
  from generate_series(1,6);

-- 15 rows per hall
do $$
begin
  for h in 1..6 loop
    insert into rows(hallId, row)
      select
      	h,
       	gs.id
      from generate_series(1,15) as gs(id);
  end loop;
end;
$$ language plpgsql;

-- 25 seats each, extraPrice by center position (up to 33%)
do $$
begin
  for h in 1..6 loop
    for r in 1..15 loop
      insert into seats(rowId, seat, extraPrice)
        select
        	r+(h-1)*15,
         	gs.id,
         	(50 * 1/(1+(gs.id-13)^2/10) + 50 * 1/(1+(r-8)^2/10)) * 0.33
        from generate_series(1,25) as gs(id);
    end loop;
  end loop;
end;
$$ language plpgsql;

-- 6 movies
insert into movies(name, duration, description, category, origin, releaseDate)
  select
  	CONCAT ('movie_', random_string((3 + random()*5)::integer)),
   	(3600 + random()*7200),
   	random_string((12 + random()*12)::integer),
   	(array['драма', 'триллер', 'комедия', 'боевик', 'хоррор'])[floor(random() * 5 + 1)],
   	(array['Индия', 'Мексика', 'Англия', 'США', 'Россия'])[floor(random() * 5 + 1)],
   	   	timestamp '1970-01-01 00:00:00' +
       random() * (timestamp '2024-08-18 00:00:00' -
                   timestamp '1970-01-01 00:00:00')
  from generate_series(1,6);
  
-- 5 shows per day each hall
do $$

begin
  for d in 1..3 loop
    for h in 1..6 loop
      insert into shows(movieId, hallId, startAt, extraPrice, maxDiscount)
        select
        	(1 + random()*5)::integer,
        	h,
        	timestamp '2024-08-18 10:00:00' + ((d - 1) ||' days')::interval + (180 * (gs.id - 1) ||' minutes')::interval,
         	gs.id * (1 + random()*10)::integer,
         	(1 + random()*33)::integer
        from generate_series(1,5) as gs(id);
    end loop;
  end loop;
end;
$$ language plpgsql;

do $$
declare
  rnd_show integer;
  rnd_seat integer;
begin
  for t in 1..30 loop
    rnd_show := floor(random() * 90 + 1);
    rnd_seat := floor(random() * 2250 + 1); -- ??
    insert into tickets(showId, seatId, soldPrice, soldAt) values
    	(rnd_show,
    	rnd_seat,
  	  (select basePrice from halls
  	    join shows on shows.hallId = halls.id
  	    where halls.id = shows.hallId and shows.id = rnd_show)
  	    * (((select extraPrice from shows where shows.id = rnd_show) +
            (select extraPrice from seats where seats.id = rnd_seat))::float / 100 + 1)
        -- discount and final price ??
            ,
    	timestamp '2024-07-24 00:00:00' +
        random() * (timestamp '2024-08-18 00:00:00' -
                    timestamp '2024-07-24 00:00:00'));
  end loop;
end;
$$ language plpgsql;
