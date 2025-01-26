CREATE INDEX "handle_movie_release_date" ON "movie" USING btree ("release_date");
CREATE INDEX "handle_ticket_sold_at" ON "ticket" USING btree ("sold_at");
CREATE INDEX "handle_session_start_time" ON "session" USING btree ((start_time::date));
CREATE INDEX "idx_ticket_session_id" ON "ticket" USING btree ("session_id");
CREATE INDEX "idx_price_session_id" ON "price" USING btree ("session_id");
