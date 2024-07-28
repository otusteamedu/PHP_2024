DROP TABLE IF EXISTS transactions;
CREATE TABLE transactions
(
    id           BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    sum          DECIMAL(8, 2) NOT NULL,
    account_from VARCHAR(255)  NOT NULL,
    account_to   VARCHAR(255)  NOT NULL,
    type         VARCHAR(255)  NOT NULL,
    status       VARCHAR(255)  NOT NULL,
    description  TEXT          NOT NULL,
    datetime     TIMESTAMP     NOT NULL
);

DROP TABLE IF EXISTS queue_reports;
CREATE TABLE queue_reports
(
    id         BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    uid        VARCHAR(255) UNIQUE NOT NULL,
    status     VARCHAR(255)  NOT NULL,
    file_path  VARCHAR(255)  NULL,
    created_at TIMESTAMP     NOT NULL,
    updated_at TIMESTAMP     NOT NULL
);

DROP TABLE IF EXISTS accounts;
CREATE TABLE accounts
(
    id         BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    uid        VARCHAR(255) UNIQUE NOT NULL
);

INSERT INTO accounts(uid) VALUES ('6685b4ccd3268'), ('2385c4dcd3261'), ('2685c4dcd3131'), ('7885c4dcd3888');

DROP TABLE IF EXISTS accounts;
CREATE TABLE accounts
(
    id         BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    uid        VARCHAR(255) UNIQUE NOT NULL
);

INSERT INTO accounts(uid) VALUES ('6685b4ccd3268'), ('2385c4dcd3261'), ('2685c4dcd3131'), ('7885c4dcd3888');



drop function if exists transactions_generate;
create function transactions_generate(qty integer, t_type varchar, t_status varchar, account_from_random varchar, account_to_random varchar) returns void
    language plpgsql
as
$$
BEGIN
    FOR transaction IN 1..qty
        LOOP
            INSERT INTO transactions (sum, account_from, account_to, type, status, datetime)
            VALUES (trunc(random() * 1000 + 1)::numeric, account_from_random, account_to_random, 'transaction', 'success', NOW());
        END LOOP;
END
$$;

do
$$
    begin
        perform transactions_generate(100000, 'transaction', 'success', '7885c4dcd3888', '6685b4ccd3268');
        perform transactions_generate(20000, 'transaction', 'error', '6685b4ccd3268', '2385c4dcd3261');
        perform transactions_generate(10000, 'refund', 'success', '2385c4dcd3261', '2685c4dcd3131');
    end
$$;