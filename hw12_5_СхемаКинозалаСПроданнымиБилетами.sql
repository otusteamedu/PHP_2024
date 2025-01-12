SELECT rown.n,
 CASE WHEN h1.sold THEN CONCAT('<SOLD>', h1.num_seat::text)
   WHEN NOT h1.sold THEN CONCAT('<empty>', h1.num_seat::text)
   ELSE '<X>'
 END as col1,
 CASE WHEN h2.sold THEN CONCAT('<SOLD>', h2.num_seat::text)
   WHEN NOT h2.sold THEN CONCAT('<empty>', h2.num_seat::text)
   ELSE '<X>'
 END as col2,
 CASE WHEN h3.sold THEN CONCAT('<SOLD>', h3.num_seat::text)
   WHEN NOT h3.sold THEN CONCAT('<empty>', h3.num_seat::text)
   ELSE '<X>'
 END as col3,
 CASE WHEN h4.sold THEN CONCAT('<SOLD>', h4.num_seat::text)
   WHEN NOT h4.sold THEN CONCAT('<empty>', h4.num_seat::text)
   ELSE '<X>'
 END as col4,
 CASE WHEN h5.sold THEN CONCAT('<SOLD>', h5.num_seat::text)
   WHEN NOT h5.sold THEN CONCAT('<empty>', h5.num_seat::text)
   ELSE '<X>'
 END as col5,
 CASE WHEN h6.sold THEN CONCAT('<SOLD>', h6.num_seat::text)
   WHEN NOT h6.sold THEN CONCAT('<empty>', h6.num_seat::text)
   ELSE '<X>'
 END as col6,
 CASE WHEN h7.sold THEN CONCAT('<SOLD>', h7.num_seat::text)
   WHEN NOT h7.sold THEN CONCAT('<empty>', h7.num_seat::text)
   ELSE '<X>'
 END as col7,
 CASE WHEN h8.sold THEN CONCAT('<SOLD>', h8.num_seat::text)
   WHEN NOT h8.sold THEN CONCAT('<empty>', h8.num_seat::text)
   ELSE '<X>'
 END as col8,
 CASE WHEN h9.sold THEN CONCAT('<SOLD>', h9.num_seat::text)
   WHEN NOT h9.sold THEN CONCAT('<empty>', h9.num_seat::text)
   ELSE '<X>'
 END as col9
 from generate_series(1, 9) rown(n) 
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 1 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h1 
  ON h1.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 2 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h2 
  ON h2.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 3 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h3 
  ON h3.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 4 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h4 
  ON h4.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 5 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h5 
  ON h5.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 6 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h6 
  ON h6.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 7 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h7 
  ON h7.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 8 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h8 
  ON h8.num_row = rown.n
  LEFT JOIN (
    SELECT t.id_session, t.num_seat, t.sold, s.num_row FROM cinema_tickets as t 
	  INNER JOIN (
	    SELECT s.uuid, r.num_row, r.num_seat FROM cinema_sessions as s INNER JOIN cinema_hall_rows as r ON s.id_hall = r.id_hall 
        WHERE r.num_col = 9 AND s.uuid = uuid('0fe6290e-b3e2-441a-b0b1-af37647cc073')
	  ) as s 
	  ON s.uuid = t.id_session AND t.num_seat = s.num_seat
  ) as h9 
  ON h9.num_row = rown.n
ORDER BY rown.n, h1.num_row, h2.num_row, h3.num_row, h4.num_row, h5.num_row, h6.num_row, h7.num_row, h8.num_row, h9.num_row  
