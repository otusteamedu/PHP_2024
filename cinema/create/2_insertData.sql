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

-- 50 movies
insert into movies(name, duration, description, category, origin, releaseDate)
  select
  	concat ('movie_', random_string((3 + random()*5)::integer)),
   	(3600 + random()*7200),
   	random_string((12 + random()*12)::integer),
   	(array['драма', 'триллер', 'комедия', 'боевик', 'хоррор'])[floor(random() * 5 + 1)],
   	(array['Индия', 'Мексика', 'Англия', 'США', 'Россия'])[floor(random() * 5 + 1)],
   	now() - interval '1 week' - random() * interval '50 years'
  from generate_series(1,50);

-- 6 halls
insert into halls(name, basePrice)
  select
  	concat ('Зал_', random_string(3)),
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

-- 5 shows per day for each hall for last 30 days
do $$
begin
  for d in 1..30 loop
    for h in 1..6 loop
      insert into shows(movieId, hallId, startAt, extraPrice, maxDiscount)
        select
        	(1 + random()*5)::integer,
        	h,
        	now()::date - (30 - d ||' days')::interval +
        	interval '10 hours' + (180 * (gs.id - 1) ||' minutes')::interval,
         	gs.id * (1 + random()*10)::integer,
         	(1 + random()*33)::integer
        from generate_series(1,5) as gs(id);
    end loop;
  end loop;
end;
$$ language plpgsql;

-- 10000 tickets
do $$
declare
  rnd_show integer;
  rnd_row integer;
  rnd_seat integer;
  hall_id integer;
  seat_id integer;
  base_price numeric;
  extra_price numeric;
  max_discount numeric;
  seat_extra_price numeric;
  sold_price numeric;
  sold_at timestamp;
begin
  for t in 1..10000 loop
    rnd_show := floor(random() * 900 + 1);  -- 5*6*30
    rnd_seat := floor(random() * 25 + 1);
    rnd_row := floor(random() * 15 + 1);
    
    select halls.id, halls.basePrice, shows.extraPrice, shows.maxDiscount, shows.startAt
    into hall_id, base_price, extra_price, max_discount, sold_at
    from halls
    join shows on shows.hallId = halls.id
    where shows.id = rnd_show;

    select seats.id, extraPrice into seat_id, seat_extra_price
    from seats
    join rows on rows.id = seats.rowId
    where rows.hallId = hall_id and rows.row = rnd_row and seats.seat = rnd_seat;

    sold_price := base_price * (1 + (extra_price + seat_extra_price - random() * max_discount ) / 100);
    sold_at := least(sold_at - random()^2 * interval '7 days', now());

    insert into tickets (showId, seatId, soldPrice, soldAt)
    values (rnd_show, seat_id, sold_price, sold_at);
  end loop;
end;
$$ language plpgsql;