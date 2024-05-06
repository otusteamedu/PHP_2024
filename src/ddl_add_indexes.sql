-- Добавление индексов
------------------------------------------------------------------------------------------------------------------------
-- Запрос 1
CREATE INDEX index__movies__release_date ON movies(release_date);

-- Запрос 2
CREATE INDEX index__tickets__sold_at ON tickets(sold_at) WHERE sold_at IS NOT NULL;

-- Запрос 3
CREATE INDEX index__sessions__starts_at ON sessions(starts_at);

-- Запрос 4
-- Дополняется индекс сделанный для запроса 2.
DROP INDEX index__tickets__sold_at;
CREATE INDEX index__tickets__sold_at ON tickets(sold_at) INCLUDE(session_id, price) WHERE sold_at IS NOT NULL;

-- Запрос 5
-- Дополняется индекс из изначальной схемы.
DROP INDEX index__tickets__session_id;
CREATE INDEX index__tickets__session_id ON tickets(session_id) INCLUDE(seat_id, sold_at);

-- Запрос 6
CREATE INDEX index__tickets__session_id__price ON tickets(session_id, price);