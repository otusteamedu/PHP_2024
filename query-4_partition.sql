/* ticket partition */

CREATE TABLE ticket_part (
    id SERIAL NOT NULL,
    schedule_id INTEGER REFERENCES schedule,
    row_number SMALLINT,
    seat_number SMALLINT,
    tariff_price DECIMAL NOT NULL,
    sale_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id, sale_datetime)
) PARTITION BY RANGE (sale_datetime);    

CREATE TABLE ticket_up_1980 PARTITION OF ticket_part
    FOR VALUES FROM ('1960-01-01 00:00:00') TO ('1980-12-31 23:59:59'); 

CREATE TABLE ticket_up_1990 PARTITION OF ticket_part
    FOR VALUES FROM ('1981-01-01 00:00:00') TO ('1990-12-31 23:59:59'); 
	
CREATE TABLE ticket_up_2000 PARTITION OF ticket_part
    FOR VALUES FROM ('1991-01-01 00:00:00') TO ('2000-12-31 23:59:59'); 
	
CREATE TABLE ticket_up_2010 PARTITION OF ticket_part
    FOR VALUES FROM ('2001-01-01 00:00:00') TO ('2010-12-31 23:59:59');
	
CREATE TABLE ticket_up_2020 PARTITION OF ticket_part
    FOR VALUES FROM ('2011-01-01 00:00:00') TO ('2020-12-31 23:59:59');
	
CREATE TABLE ticket_up_2030 PARTITION OF ticket_part
    FOR VALUES FROM ('2021-01-01 00:00:00') TO ('2023-12-31 23:59:59'); 	
	
CREATE TABLE ticket_current PARTITION OF ticket_part
    FOR VALUES FROM ('2024-01-01 00:00:00') TO ('2024-12-31 23:59:59');

INSERT INTO ticket_part (schedule_id, row_number, seat_number, tariff_price, sale_datetime)
SELECT schedule_id, row_number, seat_number, tariff_price, sale_datetime
FROM ticket;
