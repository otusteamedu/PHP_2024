CREATE EXTENSION IF NOT EXISTS "pgcrypto";

CREATE TABLE IF NOT EXISTS court_cases (
    id                 UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    general_number     TEXT NOT NULL,
    title              VARCHAR(255),
    uid                VARCHAR(255),
    case_number        VARCHAR(255),
    url                TEXT NOT NULL,
    judge_fio          VARCHAR(255),
    register_date      DATE
);

CREATE TABLE IF NOT EXISTS court_events (
    id                 UUID PRIMARY KEY DEFAULT gen_random_uuid(),
	court_case_id      UUID NOT NULL,
    event_name         VARCHAR(255),
    result_date        DATE,
    result_time        TIME,
    location           VARCHAR(255),
    result             TEXT,
    basis_for_result   TEXT,
    notes              TEXT,
    posting_date       DATE,
	CONSTRAINT fk_court_events_court_case_id
        FOREIGN KEY (court_case_id)
        REFERENCES court_cases(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS court_parties (
    id                 UUID PRIMARY KEY DEFAULT gen_random_uuid(),
	court_case_id  	   UUID NOT NULL,
    party_type     	   VARCHAR(255),
    party_name         VARCHAR(255),
	CONSTRAINT fk_court_parties_court_case_id
        FOREIGN KEY (court_case_id)
        REFERENCES court_cases(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS court_parse_statuses (
    id                 UUID PRIMARY KEY DEFAULT gen_random_uuid(),
	court_case_id  	   UUID NOT NULL UNIQUE,
    status             VARCHAR(255),
    error_type         TEXT,
	CONSTRAINT fk_court_parse_statuses_court_case_id
        FOREIGN KEY (court_case_id)
        REFERENCES court_cases(id)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS parse_status (
    id                 SERIAL PRIMARY KEY,
	status      	   BOOLEAN
);

INSERT INTO parse_status (status)
VALUES (false);