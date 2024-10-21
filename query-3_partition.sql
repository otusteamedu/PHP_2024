/* schedule partition */

CREATE TABLE schedule_part
(
    id SERIAL NOT NULL,
    time_begin TIMESTAMP NOT NULL,
    time_end TIMESTAMP NOT NULL,
    movie_id INTEGER REFERENCES movie,
    hall_id INTEGER REFERENCES hall,
    price_category_id INTEGER REFERENCES price_category,
    PRIMARY KEY (id, time_begin)
) PARTITION BY RANGE (time_begin);

CREATE TABLE schedule_up_1980 PARTITION OF schedule_part
    FOR VALUES FROM ('1960-01-01 00:00:00') TO ('1980-12-31 23:59:59'); 

CREATE TABLE schedule_up_1990 PARTITION OF schedule_part
    FOR VALUES FROM ('1981-01-01 00:00:00') TO ('1990-12-31 23:59:59'); 
	
CREATE TABLE schedule_up_2000 PARTITION OF schedule_part
    FOR VALUES FROM ('1991-01-01 00:00:00') TO ('2000-12-31 23:59:59'); 
	
CREATE TABLE schedule_up_2010 PARTITION OF schedule_part
    FOR VALUES FROM ('2001-01-01 00:00:00') TO ('2010-12-31 23:59:59');
	
CREATE TABLE schedule_up_2020 PARTITION OF schedule_part
    FOR VALUES FROM ('2011-01-01 00:00:00') TO ('2020-12-31 23:59:59');
	
CREATE TABLE schedule_up_2030 PARTITION OF schedule_part
    FOR VALUES FROM ('2021-01-01 00:00:00') TO ('2023-12-31 23:59:59'); 	
	
CREATE TABLE schedule_current PARTITION OF schedule_part
    FOR VALUES FROM ('2024-01-01 00:00:00') TO ('2024-12-31 23:59:59'); 

INSERT INTO ticket_part (schedule_id, row_number, seat_number, tariff_price, sale_datetime)
SELECT schedule_id, row_number, seat_number, tariff_price, sale_datetime
FROM ticket;
