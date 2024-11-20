DROP INDEX IF EXISTS movies_release_date_index;
DROP INDEX IF EXISTS tickets_purchase_index;
DROP INDEX IF EXISTS sessions_start_time_index;
DROP INDEX IF EXISTS tickets_session_id_index;
DROP INDEX IF EXISTS tickets_session_id_price_index;

CREATE INDEX movies_release_date_index ON movies(release_date);
CREATE INDEX tickets_purchase_index ON tickets(purchase) INCLUDE(session_id, price) WHERE purchase IS NOT NULL;
CREATE INDEX sessions_start_time_index ON sessions(start_time);
CREATE INDEX tickets_session_id_index ON tickets(session_id) INCLUDE(seat_id, purchase);
CREATE INDEX tickets_session_id_price_index ON tickets(session_id, price);