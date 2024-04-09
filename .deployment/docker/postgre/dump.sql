CREATE TABLE IF NOT EXISTS hall
(
    id   SERIAL PRIMARY KEY,
    name varchar(255) NOT NULL,
    capacity int NOT NULL,
    rows_count int NOT NULL
);
COMMENT ON TABLE hall IS 'Кинозал';
COMMENT ON COLUMN hall.name IS 'Название кинозала';
COMMENT ON COLUMN hall.capacity IS 'Общее количество сидений, вместимость зала';
COMMENT ON COLUMN hall.rows_count IS 'Количество рядов в зале';


