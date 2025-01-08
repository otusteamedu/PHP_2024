CREATE INDEX ON session (DATE(start));
CREATE INDEX ON session (movie_id);
CREATE INDEX ON session (hall_id);

CREATE INDEX ON price (session_id);
CREATE INDEX ON price (seat_type_id);

CREATE INDEX ON ticket (session_id);
CREATE INDEX ON ticket (seat_id);
CREATE INDEX ON ticket (session_id, price, discount_percent);
CREATE INDEX ON ticket (is_sold);

CREATE INDEX ON seat (hall_id);
CREATE INDEX ON seat (seat_type_id);