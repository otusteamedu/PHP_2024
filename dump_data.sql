/**
  Наполняем базу тестовыми данными
 */

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

insert into movies (title, description)
SELECT concat('movie' , id),random_string(150)
FROM generate_series(1,10000) id;

insert into halls  (title)
SELECT concat('hall' , id)
FROM generate_series(1,100) id;

INSERT INTO public.seat_categories (title,category_fee) VALUES
                                                            ('Эконом',0.0),
                                                            ('Стандартный',50.0),
                                                            ('Комфорт',100.0);
                                                           
                                                           INSERT INTO public.show_categories (title,price) VALUES
	 ('Утрений',250.0),
	 ('Дневной',350.0),
	 ('Вечерний',400.0);

DO
$$
    DECLARE
        rec record;
    BEGIN
        FOR rec IN
            select id from halls
            LOOP
                insert into seats (hall_id, seat_category_id, seat_num, row_num)
                select rec.id, 1, generate_series(1,35) seat_number , row_number  FROM generate_series(1,17) row_number;
            END LOOP;
    END;
$$
LANGUAGE plpgsql;


update seats set seat_category_id = 2 where row_num > 6 and row_num < 14 and  seat_num >= 4 and seat_num <= 31;
update seats set seat_category_id = 3 where row_num >= 14  and seat_num >= 4 and seat_num <= 31;


DO
$$
    DECLARE
        rec record;
    BEGIN
        FOR rec IN
            select id from halls
            loop
	            /* добавляем каждому залу утрение сеансы для 14 дней до и после сегодня*/
                insert into shows (begin_time, end_time, category_id, movie_id, hall_id)
                select date_trunc('day', dd):: date + time '10:00' ,
					   date_trunc('day', dd):: date + time '10:00'  + '2 hours'::interval,
						1,
						(select id from movies order by random() limit 1), 
						rec.id
				FROM generate_series ( now() - '14 days'::interval , now() + '14 days'::interval , '1 day'::interval) dd;
			
			/* добавляем каждому залу дневные сеансы для 14 дней до и после сегодня*/
                insert into shows (begin_time, end_time, category_id, movie_id, hall_id)
                select date_trunc('day', dd):: date + time '13:00' ,
					   date_trunc('day', dd):: date + time '13:00'  + '2 hours'::interval,
						2,
						(select id from movies order by random() limit 1),
						rec.id
				FROM generate_series ( now() - '14 days'::interval , now() + '14 days'::interval , '1 day'::interval) dd;
			
			/* добавляем каждому залу вечерние сеансы для 14 дней до и после сегодня*/
				insert into shows (begin_time, end_time, category_id, movie_id, hall_id)
                select date_trunc('day', dd):: date + time '18:00' ,
					   date_trunc('day', dd):: date + time '18:00'  + '2 hours'::interval,
						3,
						(select id from movies order by random() limit 1),
						rec.id
				FROM generate_series ( now() - '14 days'::interval , now() + '14 days'::interval , '1 day'::interval) dd;
			
			
            END LOOP;
    END;
$$
LANGUAGE plpgsql;




insert into tickets (show_id, seat_id, total_price, sale_time)
select s.id, st.id, category_fee + price as total, 
random() * (s.begin_time - (s.begin_time - '1 day'::interval)) + (s.begin_time - '1 day'::interval)
from shows s 
left join halls h on s.hall_id = h.id 
right join seats st on st.hall_id  = h.id
left join seat_categories sc on st.seat_category_id = sc.id
left join show_categories sc2 on sc2.id = s.category_id
where s.begin_time <= now()
order by random() limit 10000;


