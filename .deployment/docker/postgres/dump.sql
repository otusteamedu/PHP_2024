-- Выгрузки
CREATE TABLE IF NOT EXISTS bank_statement
(
    id   SERIAL PRIMARY KEY,
    client_name varchar(255) NOT NULL,
    account_number varchar(20) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    file_name varchar(255) DEFAULT NULL,
    status varchar(20) DEFAULT 'preparing',
    CONSTRAINT seat_price_check CHECK (
        (
            (status) :: text = ANY (
                ARRAY [
                    ('preparing'::character varying)::text,
                    ('ready'::character varying)::text
                    ]
                )
            )
        )
);
COMMENT ON TABLE bank_statement IS 'Банковские выгрузки';
COMMENT ON COLUMN bank_statement.client_name IS 'Имя клиента';
COMMENT ON COLUMN bank_statement.account_number IS 'Номер счета';
COMMENT ON COLUMN bank_statement.start_date IS 'Начальная дата';
COMMENT ON COLUMN bank_statement.account_number IS 'Конечная дата';
COMMENT ON COLUMN bank_statement.file_name IS 'Имя файла с выгрузкой';
COMMENT ON COLUMN bank_statement.status IS 'Статус выгрузки, preparing - готовится, ready - подготовлена, файл отправлен';
