SELECT MAX(t.price), MIN(t.price) FROM cinema_tickets as t  
WHERE id_session = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')