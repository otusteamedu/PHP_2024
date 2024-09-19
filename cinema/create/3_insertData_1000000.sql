-- 1000000 movies
insert into movies(name, duration, description, category, origin, releaseDate)
  select
  	concat ('movie_', random_string((3 + random()*5)::integer)),
   	(3600 + random()*7200),
   	random_string((12 + random()*12)::integer),
   	(array['драма', 'триллер', 'комедия', 'боевик', 'хоррор'])[floor(random() * 5 + 1)],
   	(array['Индия', 'Мексика', 'Англия', 'США', 'Россия'])[floor(random() * 5 + 1)],
   	now() - interval '1 week' - random() * interval '50 years'
  from generate_series(1,1000000);

-- 5 shows per day for each hall for next 33333 days
do $$
begin
  for d in 1..33333 loop
    for h in 1..6 loop
      insert into shows(movieId, hallId, startAt, extraPrice, maxDiscount)
        select
        	(1 + random()*5)::integer,
        	h,
        	now()::date + (d ||' days')::interval +
        	interval '10 hours' + (180 * (gs.id - 1) ||' minutes')::interval,
         	gs.id * (1 + random()*10)::integer,
         	(1 + random()*33)::integer
        from generate_series(1,5) as gs(id);
    end loop;
  end loop;
end;
$$ language plpgsql;

-- 1000000 tickets
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
  for t in 1..1000000 loop
    rnd_show := floor(random() * 9000 + 1);  -- 5*6*300
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
